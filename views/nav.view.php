<style>
    /* for bottom nav bar  */
    @media screen and (min-width: 390px) {
        #bNavbar {
            left: 38%;
            bottom: 5%;
            position: fixed;
        }
    }

    @media screen and (max-width: 390px) {
        #bNavbar {
            left: 20%;
            bottom: 5%;
            position: fixed;
        }
    }
</style>

<div id="bNavbar">
    <div class="alert alert-info border border-3 border-white shadow-sm d-flex justify-content-center gap-2 p-3"
        style="width: 240px;">
        <a href="../home.view.php" class="btn btn-outline-primary">
            <i class="fas fa-home fa-fw"></i>
        </a>
        <a href="../users/table.view.php" class="btn btn-outline-primary">
            <i class="fas fa-users fa-fw"></i>
        </a>
        <a href="../carts/cart.view.php" class="btn btn-outline-primary">
            <i class="fas fa-shopping-cart fa-fw"></i>
        </a>
        <a href="../products/table.view.php" class="btn btn-outline-primary">
            <i class="fas fa-envelope fa-fw"></i>
        </a>
    </div>
</div>