<?php include('view-header.php'); ?>
<h2>Preview</h2>
<p>Is this how we need to process this file?</p>

<?php foreach ($orders as $idcustomer => $products): ?>
    <h3>Customer ID &quot;<?php echo $idcustomer ?>&quot;</h3>
    <ul>
        <?php foreach ($products as $productcode => $amount): ?>
            <li>Product &quot;<?php echo $productcode; ?>&quot;: <strong><?php echo $amount; ?></strong>x</li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>

<p><a href="app.php?step=import"><strong>Yes, this is the right data, create orders now</strong></a>, or <a href="app.php?step=cancel">cancel import</a></p>
<?php include('view-footer.php'); ?>
