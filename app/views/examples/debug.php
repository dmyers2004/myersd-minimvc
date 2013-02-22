<pre>
<b>Benchmarks</b>
<?=number_format(memory_get_usage()/1024) ?>k
<?=number_format(memory_get_usage()/1024) ?>k (process)
<?=number_format(memory_get_peak_usage(TRUE)/1024) ?>k (process peak)
<!--<?=round(microtime(TRUE)-MT,5) ?> ms-->

<?=$that ?>
<?=$server ?>
