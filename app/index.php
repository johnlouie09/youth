<?php
session_start();
if (isset($_SESSION['barangay_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
    </style>
</head>
<body>
<div id="app">
    <v-app>
        <v-main>
            <v-container>
                <v-card class="login-container">
                    <v-card-title class="text-center">SK Official Login</v-card-title>
                    <v-card-text>
                        <form action="auth.php" method="POST">
                            <v-text-field
                                    name="username"
                                    label="Username"
                                    required
                                    outlined
                            ></v-text-field>
                            <v-text-field
                                    name="password"
                                    label="Password"
                                    type="password"
                                    required
                                    outlined
                            ></v-text-field>
                            <?php if (isset($_GET['error'])): ?>
                                <v-alert type="error" dense>
                                    Invalid username or password
                                </v-alert>
                            <?php endif; ?>
                            <v-btn
                                    type="submit"
                                    color="primary"
                                    block
                                    class="mt-4"
                            >
                                Login
                            </v-btn>
                        </form>
                    </v-card-text>
                </v-card>
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