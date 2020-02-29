sudo chmod -R 755 /var/www/magento2
FULLPATH=/var/www/magento2/2.3.4-opensource
rm -rf $FULLPATH
docker exec -i -u apache php72 sh -c "sudo chown -R apache. /var/www/magento2"
docker exec -i -u apache php72 sh -c "sudo composer self-update"
docker exec -i -u apache php72 sh -c "sudo composer config --global http-basic.repo.magento.com df3e5e5079346dffd90b78a79a0adfd0 132c0e096b5b73f9f3985f3e36aedd94"
docker exec -i -u apache php72 sh -c "cd /var/www/magento2 && composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition 2.3.4-opensource"
cd $FULLPATH
git init
git add .
git config --global user.name "Unit Tester"
git config --global user.email "unittester@magecom.net"
git commit -m "initial commit"
mysql -h0.0.0.0 -uadmin -padmin -e "DROP DATABASE IF EXISTS 2_3_4_opensource"
mysql -h0.0.0.0 -uadmin -padmin -e "CREATE DATABASE 2_3_4_opensource"
docker exec -i -u apache php72 sh -c "cd $FULLPATH && php bin/magento setup:install --backend-frontname=admin \
--base-url=http://2.3.4-opensource.magento2.local/ \
--db-host=mysql --db-name=2_3_4_opensource --db-user=admin --db-password=admin \
--admin-firstname=Admin --admin-lastname=Admin --admin-email=unittester@magecom.net \
--admin-user=admin --admin-password=admin123 --language=en_US \
--currency=USD --timezone=America/Chicago --use-rewrites=1 --cleanup-database"
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento deploy:mode:set developer"
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento config:set admin/security/use_form_key 0"
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento config:set admin/security/session_lifetime 31536000"
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento config:set admin/security/lockout_failures \"\""
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento config:set admin/security/password_lifetime \"\""
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento dev:urn-catalog:generate .idea/misc.xml"
echo "127.0.0.1       2.3.4-opensource.magento2.local" >> /etc/hosts
curl -LO http://pestle.pulsestorm.net/pestle.phar
echo pestle.phar >> .gitignore
git add .
git commit -m "install pestle.phar"
docker exec -i -u apache php72 sh -c "cd $FULLPATH && php pestle.phar magento2:generate:module Magecom UnitTest 0.0.1"
git add .
git commit -m "init module UnitTest"
docker exec -it php72 sh -c "cd $FULLPATH && php bin/magento setup:upgrade"

