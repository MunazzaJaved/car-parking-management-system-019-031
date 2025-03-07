<?php include('../../components/guest-header.php'); // Include guest header 
?>

<style>
    /* Styling for the about page image */
    .about-img {
        width: 50%;
        max-width: 40%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="container mt-5">
    <div class="text-center">
        <img src="../../assets/about.jpg" alt="About Us" class="about-img">
    </div>

    <h1>About Us</h1>

    <!-- Section: Strategic Intent -->
    <section class="mt-4">
        <h2>Strategic Intent</h2>
        <p>
            To ensure well-managed and organized parking facilities for incoming traders and visitors, reducing traffic congestion and ensuring vehicle safety.
        </p>
    </section>

    <!-- Section: Objectives of the Parking Management System -->
    <section class="mt-4">
        <h2>Objectives</h2>
        <ul>
            <li>Organized and well-managed parking facility</li>
            <li>Transparent parking fee collection using an IT-based Parking Management System (PMS)</li>
            <li>Secure and theft-free parking</li>
            <li>One-way traffic enforcement with separate entry-exit points</li>
            <li>Loading/unloading bays where required</li>
            <li>Clear and accessible parking spaces for visitors</li>
            <li>Prevention of traffic congestion on main and internal roads</li>
            <li>Additional parking provisions for special events like Eid ul Azha</li>
        </ul>
    </section>

    <!-- Section: Parking Rates Table -->
    <section class="mt-4">
        <h2>Approved Parking Rates</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vehicle Type</th>
                    <th>Amount in PKR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>22 Wheelers</td>
                    <td>2500</td>
                </tr>
                <tr>
                    <td>10 Wheelers</td>
                    <td>1200</td>
                </tr>
                <tr>
                    <td>Bradford Truck</td>
                    <td>1100</td>
                </tr>
                <tr>
                    <td>Mazda Dala</td>
                    <td>1000</td>
                </tr>
                <tr>
                    <td>Shezore</td>
                    <td>300</td>
                </tr>
                <tr>
                    <td>Pickup</td>
                    <td>150</td>
                </tr>
                <tr>
                    <td>Rickshaw</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>Car</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>Bike</td>
                    <td>20</td>
                </tr>
            </tbody>
        </table>
    </section>
</div>

<?php include('../../components/footer.php'); // Include footer if available 
?>