
# ================================================
# Enable firewall rule
#
# Documentation: https://help.ubuntu.com/community/UFW
# ================================================

{{ $rule->toBashEnableCommand() }}
