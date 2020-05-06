# make sure to `npm run build` first so that webpack gets built with prod mode on. Dev build: 2.1MB, prod build: ~450KB
ssh -t koihealth@koihealth.ssh.wpengine.net  'cd /home/wpe-user/sites/koihealth/wp-content/themes/;rm -rf KOI-2019/*;exit;bash'
rsync -r --progress --exclude=".*" --exclude="node_modules" ./ koihealth@koihealth.ssh.wpengine.net:/home/wpe-user/sites/koihealth/wp-content/themes/KOI-2019
