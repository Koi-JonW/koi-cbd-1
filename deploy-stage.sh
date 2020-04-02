# before running this, `npm run build` and wait for CSS/JS to get fully built
rsync -r --update --progress --exclude=".*" --exclude-from="./.exclude" ./ koicbdstaging@koicbdstaging.ssh.wpengine.net:/home/wpe-user/sites/koicbdstaging/wp-content/themes/KOI-2019
