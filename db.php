<?php
$conn = mysqli_connect("localhost","root","","catkart");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Self-healing check for image paths in case database contains old external URLs
if ($conn) {
    // Check if any breeds table image points to external URLs or is blank/null
    $check_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM breeds WHERE image LIKE 'http%' OR image = '' OR image IS NULL");
    if ($check_query) {
        $row = mysqli_fetch_assoc($check_query);
        if (isset($row['count']) && $row['count'] > 0) {
            $correct_images = [
                'Persian' => 'images/persian.png',
                'Siamese' => 'images/siamese.png',
                'Maine Coon' => 'images/maine_coon.png',
                'Bengal' => 'images/bengal.png',
                'Sphynx' => 'images/sphynx.png',
                'Ragdoll' => 'images/ragdoll.png',
                'British Shorthair' => 'images/british_shorthair.jpg',
                'Scottish Fold' => 'images/scottish_fold.png',
                'Cat Collar' => 'images/collar.png',
                'Cat Scratching Post' => 'images/scratching_post.jpg',
                'Cat Toy Mouse' => 'images/toy_mouse.png',
                'Cat Carrier' => 'images/carrier.png',
                'Cat Bed' => 'images/catbed.png',
                'LED Cat Toy' => 'images/led_cat_toy.png',
                'Feline Grooming Kit' => 'images/feline_grooming_kit.png',
                'Window Perch' => 'images/window_perch.png',
                'Catnip Wand' => 'images/catnip_wand.png',
                'Premium Cat Kibble' => 'images/kibble.jpg',
                'Wet Salmon Feast' => 'images/salmon_feast.png',
                'Cat Treats' => 'images/treats.png',
                'Organic Cat Grass' => 'images/cat_grass.png',
                'Grain-Free Chicken Pate' => 'images/grain_free_chicken_pate.png',
                'Salmon & Tuna Feast' => 'images/salmon_tuna_feast.png',
                'Organic Turkey Meal' => 'images/organic_turkey_meal.png',
                'Dental Care Snacks' => 'images/dental_care_snacks.png'
            ];
            foreach ($correct_images as $breed => $path) {
                $safe_breed = mysqli_real_escape_string($conn, $breed);
                $safe_path = mysqli_real_escape_string($conn, $path);
                mysqli_query($conn, "UPDATE breeds SET image = '$safe_path' WHERE breed = '$safe_breed'");
            }
        }
    }
}
?>