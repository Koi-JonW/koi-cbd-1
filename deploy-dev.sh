# before running this, `npm run dev` and wait for CSS/JS to get fully built
rsync -r --update --progress --exclude=".*" --exclude-from="./.exclude" ./ koicbddev@koicbddev.ssh.wpengine.net:/home/wpe-user/sites/koicbddev/wp-content/themes/KOI-2019