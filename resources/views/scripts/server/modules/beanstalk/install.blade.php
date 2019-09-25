
# ================================================
# Install Beanstalk
# ================================================

apt-get install -y --force-yes beanstalkd
sed -i "s/BEANSTALKD_LISTEN_ADDR.*/BEANSTALKD_LISTEN_ADDR=0.0.0.0/" /etc/default/beanstalkd

if grep START= /etc/default/beanstalkd; then
sed -i "s/#START=yes/START=yes/" /etc/default/beanstalkd
else
echo "START=yes" >> /etc/default/beanstalkd
fi

service beanstalkd start
sleep 5
service beanstalkd restart

systemctl enable beanstalkd
