<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error" onclick="this.classList.add('hidden');">
    <i class="fas fa-exclamation-circle"></i> Error <br/>
    <?= $message ?> <br/>
    Click on this tooltip to dismiss it.
</div>
