<?php include('view-header.php'); ?>

<h2>Import your Excel</h2>
<p>Upload your Excel you want to import as orders.</p>
<p>Use 1 column per customer, and 1 row per product.</p>
<form method="post" action="app.php?step=preview" enctype="multipart/form-data">
    <p>
        <label for="file">Excel file (.xlsx)</label><br/>
        <input type="file" name="file" id="file">
    </p>
    <p>
        <label for="reference">Order reference for all orders</label><br/>
        <input type="text" name="reference" id="reference">
    </p>
    <p>
        <label for="customernumbers-rule">In which row are the customer numbers entered?</label><br/>
        <input type="text" name="customernumbers-rule" id="customernumbers-rule" value="<?php echo $config['default-customernumbers-rule'] ?>">
    </p>
    <p>
        <label for="productcode-column">In which column are the product codes entered?</label><br/>
        <input type="text" name="productcode-column" id="productcode-column" value="<?php echo $config['default-productcode-column'] ?>">
    </p>
    <p>
        <label for="start-row">At which row number starts the order rules?</label><br/>
        <input type="text" name="start-row" id="start-row" value="<?php echo $config['default-start-row'] ?>">
    </p>
    <p>
        <label for="start-column">At which column number starts the order rules?</label><br/>
        <input type="text" name="start-column" id="start-column" value="<?php echo $config['default-start-column'] ?>">
    </p>
    <p><input type="submit" value="Upload"></p>
</form>

<?php include('view-footer.php'); ?>
