<?php

    if(isset($_GET['senha']))
        echo crypt($_GET['senha'], '$2a$12$jALKAJSeqwnaSEnxcjayeE$');
