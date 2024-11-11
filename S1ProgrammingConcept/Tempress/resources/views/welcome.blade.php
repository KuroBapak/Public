<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TempPress Monitor</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Light and Dark Mode Styling */
        body.light-mode {
            background-color: #f4f4f9;
            color: #333;
        }
        body.dark-mode {
            background-color: #2c2c2c;
            color: #fff;
        }

        /* Severity bar */
        .severity-bar {
            width: 100%;
            height: 30px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #00e676;
            transition: background-color 0.5s;
        }

        /* Dark mode styling for the modal content */
        .modal-content.dark-mode {
            background-color: #333;
            color: #fff;
        }
    </style>

<script type="text/javascript">
    $(document).ready(function() {
        const fetchInterval = 5000; // 5 seconds
        const normalPressure = 101325; // Standard pressure in Pa

        // Flags to track notifications
        let tempNotified = false;
        let pressNotified = false;

        // Variable to store the selected mode (light, dark, auto)
        let selectedMode = "light"; // Default mode

        function fetchData() {
            $("#temp").load("{!! url('bacatemp') !!}");
            $("#press").load("{!! url('bacapress') !!}");
            $("#avgt").load("{!! url('bacaavgt') !!}");
            $("#avgs").load("{!! url('bacaavgs') !!}");

            // Check the `bacalight` value only if auto mode is selected
            if (selectedMode === "auto") {
                $("#light").load("{!! url('bacalight') !!}", function(lightValue) {
                    const trimmedLightValue = lightValue.trim();
                    console.log("Auto Mode - bacalight Value:", trimmedLightValue); // Debugging output

                    // Apply mode based on `bacalight` value
                    if (trimmedLightValue === "1") {
                        console.log("Switching to Light Mode based on bacalight value"); // Debugging output
                        applyMode("light");
                    } else if (trimmedLightValue === "0") {
                        console.log("Switching to Dark Mode based on bacalight value"); // Debugging output
                        applyMode("dark");
                    } else {
                        console.warn("Unexpected bacalight value:", trimmedLightValue); // In case of an unexpected value
                    }
                });
            }

            checkLimits(); // Check if values are within the limit
        }

        function checkLimits() {
            const tempLimitLow = parseFloat($("#tempLimitLow").val());
            const tempLimitHigh = parseFloat($("#tempLimitHigh").val());
            const pressLimitLow = parseFloat($("#pressLimitLow").val());
            const pressLimitHigh = parseFloat($("#pressLimitHigh").val());

            const currentTemp = parseFloat($("#temp").text());
            const currentPress = parseFloat($("#press").text());

            let notificationMessage = ""; // Variable to hold combined notification message

            // Check temperature limits and update notification message
            if (currentTemp < tempLimitLow && !tempNotified) {
                notificationMessage += "Temperature is below the standard limit! ";
                tempNotified = true;
            } else if (currentTemp > tempLimitHigh && !tempNotified) {
                notificationMessage += "Temperature is above the standard limit! ";
                tempNotified = true;
            } else if (currentTemp >= tempLimitLow && currentTemp <= tempLimitHigh) {
                tempNotified = false; // Reset flag if temperature is back within limits
            }

            // Check pressure limits and update notification message
            if (currentPress < pressLimitLow && !pressNotified) {
                notificationMessage += "Air pressure is below the standard limit! ";
                pressNotified = true;
            } else if (currentPress > pressLimitHigh && !pressNotified) {
                notificationMessage += "Air pressure is above the standard limit! ";
                pressNotified = true;
            } else if (currentPress >= pressLimitLow && currentPress <= pressLimitHigh) {
                pressNotified = false; // Reset flag if pressure is back within limits
            }

            // Display notification modal if there is a message to show
            if (notificationMessage !== "") {
                $("#notificationText").text(notificationMessage);
                $("#notificationModal").modal('show');
            }

            // Severity bar color logic based on pressure deviation
            const pressureDifference = Math.abs(currentPress - normalPressure);
            if (pressureDifference <= 5000) {
                $(".severity-bar").css("background-color", "#00e676"); // Green
            } else if (pressureDifference <= 15000) {
                $(".severity-bar").css("background-color", "#ffea00"); // Yellow
            } else {
                $(".severity-bar").css("background-color", "#ff4e42"); // Red
            }
        }

        // Fetch data at intervals
        setInterval(fetchData, fetchInterval);

        // Mode toggle functionality
        function applyMode(mode) {
            if (mode === 'dark') {
                $("body").removeClass("light-mode").addClass("dark-mode");
                $(".modal-content").addClass("dark-mode"); // Apply dark mode to modals
                console.log("Applied Dark Mode"); // Debugging output
            } else if (mode === 'light') {
                $("body").removeClass("dark-mode").addClass("light-mode");
                $(".modal-content").removeClass("dark-mode"); // Remove dark mode from modals
                console.log("Applied Light Mode"); // Debugging output
            }
        }

        $("#modeSelect").change(function() {
            selectedMode = $(this).val(); // Update the selected mode
            console.log("Mode selected:", selectedMode); // Debugging output
            if (selectedMode !== "auto") {
                applyMode(selectedMode); // Apply mode if not auto
            }
        });

        $("#settingsBtn").click(function() {
            $("#settingsModal").modal('show');
        });
    });
</script>



</head>

<body class="light-mode">
    <div class="container">
        <h1>TempPress Monitor</h1>

        <!-- Severity Level Bar -->
        <div class="severity-bar"></div>

        <!-- Real-time Data Display -->
        <h2>Current Temperature: <span id="temp">Unloaded</span> °C</h2>
        <h2>Current Pressure: <span id="press">Unloaded</span> Pa</h2>
        <h2>Average Temperature: <span id="avgt">Unloaded</span> °C</h2>
        <h2>Average Pressure: <span id="avgs">Unloaded</span> Pa</h2>

        <!-- Settings Button -->
        <button id="settingsBtn" class="btn btn-primary mt-3">Settings</button>
    </div>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="notificationText"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Temperature Lower Limit:</label>
                    <input type="number" id="tempLimitLow" class="form-control" placeholder="Enter lower temp limit" value="20"> °C <br>

                    <label>Temperature Upper Limit:</label>
                    <input type="number" id="tempLimitHigh" class="form-control" placeholder="Enter upper temp limit" value="26"> °C <br>

                    <label>Pressure Lower Limit:</label>
                    <input type="number" id="pressLimitLow" class="form-control" placeholder="Enter lower pressure limit" value="100000"> Pa <br>

                    <label>Pressure Upper Limit:</label>
                    <input type="number" id="pressLimitHigh" class="form-control" placeholder="Enter upper pressure limit" value="110000"> Pa <br>

                    <label>Mode:</label>
                    <select id="modeSelect" class="form-control">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="auto">Auto</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>