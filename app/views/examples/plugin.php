<p>Base 64 Encode</p>
<p><?=$filterStringer->encode($input) ?><br>
<small>of course this could have been done without the plugin using the global function but, it's just an example</small>
<p><?=$filterStringer->decode($input) ?><br>
<p>Left 3 <?=$filterStringer->left($input,3) ?></p>
