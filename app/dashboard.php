<?php
session_start();
if (!isset($_SESSION['barangay_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Admin Dashboard</title>
   <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-app>
        <v-app-bar app color="primary" dark>
            <v-toolbar-title>SK Admin Dashboard</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn text href="logout.php">Logout</v-btn>
        </v-app-bar>

        <v-main>
            <v-container>
                <v-card class="mb-4">
                    <v-card-text>
                        <h2 class="text-h4 mb-2">Welcome, <?php echo htmlspecialchars($_SESSION['sk_name']); ?>!</h2>
                        <p class="text-h6">Barangay <?php echo htmlspecialchars($_SESSION['barangay_name']); ?></p>
                    </v-card-text>
                </v-card>

                <!-- Add your dashboard content here -->
            </v-container>
        </v-main>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
    })
</script>
</body>
</html>