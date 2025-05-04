<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>First Term Amount</th>
            <th>Second Term Amount</th>
            <th>Third Term Amount</th>
            <th>Annual Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        try {
            $query = "SELECT
                        id AS fee_id, 
                        type,
                        first_term, 
                        second_term, 
                        third_term, 
                        annual 
                      FROM compulsory_fees 
                      WHERE class_id = ?";

            $stmt = $pdo->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . implode(" ", $pdo->errorInfo()));
            }

            if (!$stmt->execute([$c_id])) {
                throw new Exception("Failed to execute statement: " . implode(" ", $stmt->errorInfo()));
            }

            $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$invoices) {
                throw new Exception("Failed to fetch data: " . implode(" ", $stmt->errorInfo()));
            }

            foreach ($invoices as $index => $invoice) : ?>
                <tr>
                    <td><?= htmlspecialchars($index + 1, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($invoice['type'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['first_term'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['second_term'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['third_term'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td>
                        <?php
                        $formatted_amount = '₦' . number_format($invoice['annual'], 2);
                        echo htmlspecialchars($formatted_amount, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                </tr>
        <?php endforeach;
        } catch (Exception $e) {
            echo '<tr><td colspan="7" style="color: red;">Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</td></tr>';
        }
        ?>
    </tbody>
</table>