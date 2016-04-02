<?php

return [
    'loop'     => [
        'pattern'     => '/(?<!\\w)(\\s*)@loop(?:\\s*)\\((.*)(?:\\sas)(.*)\\)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.loop')->newLoop($2);
foreach(app('blade.loop')->getLastStack()->getItems() as $3):
$loop = app('blade.loop')->loop();
?>
EOT
    ],

    'endloop'  => [
        'pattern'     => '/(?<!\\w)(\\s*)@endloop(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.loop')->looped();
endforeach;
app('blade.loop')->endLoop($loop);
?>$2
EOT
    ],

    'break'    => [
        'pattern'     => '/(?<!\\w)(\\s*)@break(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
    break;
?>$2
EOT
    ],

    'continue' => [
        'pattern'     => '/(?<!\\w)(\\s*)@continue(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.loop')->looped();
continue;
?>$2
EOT
    ],
];
