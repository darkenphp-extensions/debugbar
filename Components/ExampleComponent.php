<?php

use Darken\Attributes\ConstructorParam;

$example = new class {
    #[ConstructorParam]
    public string $param;
}
?>
<div style="padding: 20px; background-color: green; color:white; border-radius: 20px;">
    <?= $example->param ?>
</div>