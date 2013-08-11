mobile site checker

INSTALL

$ crontab -e

add the processor. It will keep only one instance, so you can run it every minute

* * * * * cd /var/www/msc/ && php process.php > /var/www/msc/msc.log 2>&1