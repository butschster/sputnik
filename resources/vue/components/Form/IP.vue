<template>
    <div class="form-group form-group-labeled" :class="{'is-invalid': httpErrors.has(name), 'is-required': required}">
        <div class="form-control form-control-ip">
            <input type="text" maxlength="3" class="ip-segment-input" :value="segment"
                   :placeholder="placeholder"
                   v-on:keydown="onInputKeydown($event, index)"
                   v-on:input="onInput($event, index)"
                   v-on:blur="onInputBlur()"
                   v-on:paste="onPaste($event, index)"
                   v-for="(segment, index) in segments">
        </div>

        <label :for="name">{{ label }}</label>

        <span class="invalid-feedback" role="alert" v-if="httpErrors.has(name)">
            <strong>{{ httpErrors.first(name) }}</strong>
        </span>
    </div>
</template>

<script>
    function getRange(el) {
        var cuRange;
        var tbRange;
        var headRange;
        var range;
        var dupRange;
        var ret = {};
        if (el.setSelectionRange) {
            // standard
            ret.begin = el.selectionStart;
            ret.end = el.selectionEnd;
            ret.result = el.value.substring(ret.begin, ret.end);
        } else if (document.selection) {
            // ie
            if (el.tagName.toLowerCase() === 'input') {
                cuRange = document.selection.createRange();
                tbRange = el.createTextRange();
                tbRange.collapse(true);
                tbRange.select();
                headRange = document.selection.createRange();
                headRange.setEndPoint('EndToEnd', cuRange);
                ret.begin = headRange.text.length - cuRange.text.length;
                ret.end = headRange.text.length;
                ret.result = cuRange.text;
                cuRange.select();
            } else if (el.tagName.toLowerCase() === 'textarea') {
                range = document.selection.createRange();
                dupRange = range.duplicate();
                dupRange.moveToElementText(el);
                dupRange.setEndPoint('EndToEnd', range);
                ret.begin = dupRange.text.length - range.text.length;
                ret.end = dupRange.text.length;
                ret.result = range.text;
            }
        }
        el.focus();
        return ret;
    }

    export default {
        props: {
            value: String,
            name: String,
            label: String,
            required: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                segments: ['', '', '', '']
            };
        },
        watch: {
            value(ip) {
                this.syncIp(ip);
            }
        },
        methods: {
            onInputKeydown(event, index) {
                var keyCode = event.keyCode || event.which;
                var value = event.target.value;
                if (keyCode === 8 || keyCode === 37) {
                    // move the cursor to previous input if backspace and left arrow is pressed at the begin of one input
                    if ((value.length === 0 || getRange(event.target).end === 0) &&
                        index > 0) {
                        this.$el.getElementsByTagName('input')[index - 1].focus();
                        // When jump to pre input(enter "backspace"), thr cursor should in the end.
                        // before fix: 127.|0.0.0  =>   12|7.0.0.1
                        // after fix: 127.|0.0.0 = >   127|.0.0.0
                        // notes: "|" mean the cursor position.
                        event.preventDefault();
                    }
                } else if (keyCode === 39) {
                    if (getRange(event.target).end === value.length && index < 3) {
                        // move to cursor to the next input if right arrow is pressed at the end of one input
                        this.$el.getElementsByTagName('input')[index + 1].focus();
                    }
                }
            },
            onInput(event, index) {
                var value = event.target.value;
                event.target.value = this.segments[index];
                var segment = Number(value);
                if (isNaN(segment)) {
                    return;
                } else if (value === '') {
                    this.segments.splice(index, 1, '');
                } else if (segment > 255 || segment < 0) {
                    // set the segment to 255 if out of ip range
                    this.segments.splice(index, 1, 255);
                } else {
                    this.segments.splice(index, 1, segment);
                }
                // jump to next input
                if (value.length === 3 && index < 3 || value[value.length - 1] === '.') {
                    this.$el.getElementsByTagName('input')[index + 1].focus();
                }
            },
            onInputBlur() {
                setTimeout(() => {
                    var className = document.activeElement.className;
                    if (className.indexOf('ip-segment-input') === -1) {
                        if (this.onBlur) {
                            this.onBlur(this.segments.join('.'));
                        }
                    }
                }, 50);
            },
            onPaste(e, index) {
                var pasteText = e.clipboardData.getData('text/plain');
                var segments = pasteText.split('.');
                segments.forEach((segment, i) => {
                    if (index + i < 4 && !isNaN(segment) &&
                        segment >= 0 && segment <= 255) {
                        this.segments.splice(index + i, 1, segment);
                    }
                });
                e.preventDefault();
            },
            syncIp(ip) {
                if (ip && ip.indexOf('.') !== -1) {
                    ip.split('.').map((segment, index) => {
                        if (isNaN(segment) || segment < 0 || segment > 255) {
                            segment = 255;
                        }
                        this.segments.splice(index, 1, segment);
                        return segment;
                    });
                }
            },
            onChange(ip) {
                this.$emit('value', ip)
            }
        },
        mounted() {
            this.syncIp(this.ip);
            this.$watch(() => {
                return this.segments.join('.');
            }, (val, oldValue) => {
                if (val !== oldValue) {
                    if (val === '...') {
                        val = '';
                    }
                    if (this.onChange) {
                        this.onChange(val);
                    }
                }
            });
        }
    }
</script>