# before running this, `npm run dev` and wait for CSS/JS to get fully built
ssh -t koicbddev@koicbddev.ssh.wpengine.net  'cd /home/wpe-user/sites/koicbddev/wp-content/themes/;rm -rf KOI-2019/*;exit;bash'
rsync -r --progress --exclude=".*" --exclude="node_modules" ./ koicbddev@koicbddev.ssh.wpengine.net:/home/wpe-user/sites/koicbddev/wp-content/themes/KOI-2019
