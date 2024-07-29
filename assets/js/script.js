
        // Function to toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            if (sidebar.style.width === "250px" || sidebar.style.width === "") {
                sidebar.style.width = "0";
                document.querySelector(".main").style.marginLeft = "0";
            } else {
                sidebar.style.width = "250px";
                document.querySelector(".main").style.marginLeft = "250px";
            }
        }

        // Load sidebar.html into the sidebar-container
        document.addEventListener("DOMContentLoaded", function() {
            fetch("sidenav.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("sidebar-container").innerHTML = data;
                })
                .catch(error => console.error('Error loading sidebar:', error));
        });
    