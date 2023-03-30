<style>
    /* for bottom nav bar  */
    @media screen and (min-width: 390px) {
        #bNavbar {
            left: 42%;
            bottom: 5%;
            position: fixed;
        }
    }

    @media screen and (max-width: 390px) {
        #bNavbar {
            left: 12%;
            bottom: 5%;
            position: fixed;
        }
    }
</style>

<div id="bNavbar">
    <div class="alert alert-info border border-3 border-white shadow-sm d-flex justify-content-center gap-3"
        style="width: 300px;">
        <a href="../home.view.php" class="btn btn-outline-primary">
            <i class="fas fa-home fa-lg fa-fw py-3"></i>
        </a>
        <a href="../users/table.view.php" class="btn btn-outline-primary">
            <i class="fas fa-users fa-lg fa-fw py-3"></i>
        </a>
        <a href="../carts/cart.view.php" class="btn btn-outline-primary">
            <i class="fas fa-shopping-cart fa-lg fa-fw py-3"></i>
        </a>
        <a href="../products/table.view.php" class="btn btn-outline-primary">
            <i class="fas fa-envelope fa-lg fa-fw py-3"></i>
        </a>
    </div>
</div>