<?php
$json = shell_exec("python3 /full/path/to/make_table.py");
$data = json_decode($json, true);

echo "<table border='1'>";
echo "<tr><th>a</th><th>b</th><th>c</th></tr>";
foreach ($data['a'] as $i => $a) {
    echo "<tr>";
    echo "<td>".$a."</td>";
    echo "<td>".$data['b'][$i]."</td>";
    echo "<td>".$data['c'][$i]."</td>";
    echo "</tr>";
}
echo "</table>";
?>
