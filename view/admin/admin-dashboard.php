<?php
include('../../components/admin-header.php');
include('../../config.php'); ?>

<div class="container mt-3" style="text-align: center;">

    <h1>Admin Dashboard</h1>
    <p>Here you can manage users and perform other administrative tasks.</p>
</div>
<div class="buttons" style="display:flex; margin-top:10px; justify-content:center;">
    <a style="margin-right: 10px;" href="./manage-parking-slots.php" class="btn btn-success">Manage Parking Slots</a><br>
    <a href="./manage-reservations.php" class="btn btn-info">View All Reservations</a><br>
</div>

<?php include('../../components/footer.php'); ?>