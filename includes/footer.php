<?php

/*
This code to implement the footer has been used with some modification from the submission
for Assignment 3 by Student Nhi Ly in CSCI 2170 (Winter 2021).
Nhi Ly, Assignment 3: CSCI 2170 (Winter 2021), Faculty of Computer Science,
Dalhousie University. Available online on Gitlab at [URL]:
https://git.cs.dal.ca/courses/2021-winter/csci-2170/a3/nly.
Date accessed: 21 Mar 2021.
*/

// Access control
require_once "access-check.php";
?>
<footer id="pg-footer" class="text-white py-5 bg-dark">
    <div class="container">
        <p class="float-end mb-1">
            <a href="#" class="text-info">Back to top</a>
        </p>
        <p class="mb-1">&copy; 2021 Jedi Blog Inc.</p>
    </div>
</footer>

<?php
// Close the database connection
if (isset($dbconnection)){
    $dbconnection->close();
}
?>

<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>
