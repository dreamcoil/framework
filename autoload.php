<?php

require __DIR__ . '/Console.php';

require __DIR__ . '/Constants.php';

require __DIR__ . '/Config.php';

require __DIR__ . '/Routing.php';

require __DIR__ . '/View.php';

require __DIR__ . '/Layout.php';

require __DIR__ . '/Translate.php';

require __DIR__ . '/Auth.php';

require __DIR__ . '/MysqlAdapter.php';

require __DIR__ . '/Getter.php';

require __DIR__ . '/Codebowl/Title.php';

require __DIR__ . '/Codebowl/Verify.php';

require __DIR__ . '/Codebowl/Random.php';

require __DIR__ . '/Dreamcoil.php';

require __DIR__ . '/Phase.php';

require __DIR__ . '/Debug.php';

require __DIR__ . '/ErrorHandler.php'

require __DIR__ . '/Cron.php';

set_error_handler("DreamcoilErrorHandler");
