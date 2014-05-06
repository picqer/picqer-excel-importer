<?php include('view-header.php'); ?>

<h2>Orders processed</h2>
<p>We processed the file and generated the following orders:</p>

<ul>
    <?php foreach ($orderids as $orderid): ?>
        <li>Order <?php echo $orderid; ?></li>
    <?php endforeach; ?>
</ul>

<p><a href="app.php?step=upload"><strong>Import another file</strong></a></p>

<?php include('view-footer.php'); ?>