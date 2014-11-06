<?php
    header("Location: reader.php?manga=".filter_input(INPUT_GET, "manga")."&vol=".filter_input(INPUT_GET, "vol"));
?>