
# ================================================
# Set Locale
# ================================================
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
locale-gen en_US.UTF-8
localedef -i en_US -f UTF-8 en_US.UTF-8
dpkg-reconfigure --frontend noninteractive locales