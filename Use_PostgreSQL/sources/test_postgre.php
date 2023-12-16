<?php
$conn2 = pg_connect("host=localhost dbname=fruit_shop user=postgres password=admin123");
$query2 = "SELECT * FROM users ORDER BY id_user ASC";
$result2 = pg_query($conn2, $query2);
// print the result
if (!$result2) {
    echo "An error occurred.\n";
    exit;
}
echo "<table>";
echo "<tr>";
echo "<th width='20%'>User ID</th>";
echo "<th width='30%'>User Name</th>";
echo "<th width='20%'>Password</th>";
echo "<th width='20%'>Wallet</th>";
echo "<th width='20%'>Role</th>";

echo "</tr>";
while ($row = pg_fetch_row($result2)) {
    echo "<tr>";
    echo "<td>$row[0]</td>";
    echo "<td>$row[1]</td>";
    echo "<td>$row[2]</td>";
    echo "<td>$row[3]</td>";
    echo "<td>$row[4]</td>";
    echo "td>$row[5]</td>";
    echo "td>$row[6]</td>";
    echo "</tr>";
}
echo "</table>";
?>
