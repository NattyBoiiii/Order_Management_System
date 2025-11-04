document.addEventListener('DOMContentLoaded', function() {
    const dateStartInput = document.getElementById('dateStart');
    const dateEndInput = document.getElementById('dateEnd');
    const filterBtn = document.getElementById('filterBtn');
    const clearBtn = document.getElementById('clearBtn');
    const printPdfBtn = document.getElementById('printPdfBtn');
    const transactionsTableBody = document.getElementById('transactionsTableBody');
    const totalSumElement = document.getElementById('totalSum');
    
    let currentTransactions = [];
    let currentTotalSum = 0;
    let currentDateStart = '';
    let currentDateEnd = '';
    
    loadTransactions();
    
    filterBtn.addEventListener('click', function() {
        loadTransactions();
    });
    
    clearBtn.addEventListener('click', function() {
        dateStartInput.value = '';
        dateEndInput.value = '';
        loadTransactions();
    });
    
    printPdfBtn.addEventListener('click', function() {
        printPdf();
    });
    
    function loadTransactions() {
        const dateStart = dateStartInput.value;
        const dateEnd = dateEndInput.value;
        
        currentDateStart = dateStart;
        currentDateEnd = dateEnd;
        
        let queryString = '';
        if (dateStart) {
            queryString += 'date_start=' + encodeURIComponent(dateStart);
        }
        if (dateEnd) {
            if (queryString) queryString += '&';
            queryString += 'date_end=' + encodeURIComponent(dateEnd);
        }
        
        transactionsTableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Loading transactions...</td></tr>';
        
        fetch('api_folder/transactions.php' + (queryString ? '?' + queryString : ''))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentTransactions = data.data;
                    currentTotalSum = data.total_sum;
                    displayTransactions(data.data);
                    displayTotalSum(data.total_sum);
                } else {
                    currentTransactions = [];
                    currentTotalSum = 0;
                    transactionsTableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-red-500">Error: ' + (data.message || 'Failed to load transactions') + '</td></tr>';
                    totalSumElement.textContent = '₱0.00';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                currentTransactions = [];
                currentTotalSum = 0;
                transactionsTableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-red-500">Error loading transactions. Please try again.</td></tr>';
                totalSumElement.textContent = '₱0.00';
            });
    }
    
    function displayTransactions(transactions) {
        if (!transactions || transactions.length === 0) {
            transactionsTableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No transactions found.</td></tr>';
            return;
        }
        
        let html = '';
        transactions.forEach(transaction => {
            const items = JSON.parse(transaction.items || '[]');
            const itemsList = items.map(item => `${item.name} (x${item.quantity})`).join(', ');
            
            const dateAdded = new Date(transaction.date_added);
            const formattedDate = dateAdded.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            let cashierName = 'Customer Order';
            if (transaction.cashier_id && transaction.cashier_id !== '0' && transaction.cashier_id !== 0) {
                cashierName = transaction.first_name && transaction.last_name 
                    ? `${transaction.first_name} ${transaction.last_name}` 
                    : (transaction.cashier_username || 'N/A');
            }
            
            html += `
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-4 py-3">#${transaction.transaction_id}</td>
                    <td class="px-4 py-3">${formattedDate}</td>
                    <td class="px-4 py-3">${itemsList || 'N/A'}</td>
                    <td class="px-4 py-3">${cashierName}</td>
                    <td class="px-4 py-3 text-right font-semibold">₱${parseFloat(transaction.total_amount).toFixed(2)}</td>
                </tr>
            `;
        });
        
        transactionsTableBody.innerHTML = html;
    }
    
    function displayTotalSum(totalSum) {
        totalSumElement.textContent = '₱' + parseFloat(totalSum || 0).toFixed(2);
    }
    
    function printPdf() {
        if (!currentTransactions || currentTransactions.length === 0) {
            alert('No transactions to print. Please load transactions first.');
            return;
        }
        
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4'); 
        
        doc.setFontSize(18);
        doc.text('Transaction Reports - Ichiban Bowl Ordering System', 14, 15);
        
        doc.setFontSize(10);
        let dateRangeText = 'All Transactions';
        if (currentDateStart && currentDateEnd) {
            dateRangeText = `From ${formatDateForPdf(currentDateStart)} to ${formatDateForPdf(currentDateEnd)}`;
        } else if (currentDateStart) {
            dateRangeText = `From ${formatDateForPdf(currentDateStart)}`;
        } else if (currentDateEnd) {
            dateRangeText = `Until ${formatDateForPdf(currentDateEnd)}`;
        }
        doc.text(`Date Range: ${dateRangeText}`, 14, 22);
        doc.text(`Generated: ${new Date().toLocaleString()}`, 14, 27);
        
        const tableData = currentTransactions.map(transaction => {
            const items = JSON.parse(transaction.items || '[]');
            const itemsList = items.map(item => `${item.name} (x${item.quantity})`).join(', ');
            
            const dateAdded = new Date(transaction.date_added);
            const formattedDate = dateAdded.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            let cashierName = 'Customer Order';
            if (transaction.cashier_id && transaction.cashier_id !== '0' && transaction.cashier_id !== 0) {
                cashierName = transaction.first_name && transaction.last_name 
                    ? `${transaction.first_name} ${transaction.last_name}` 
                    : (transaction.cashier_username || 'N/A');
            }
            
            const amount = parseFloat(transaction.total_amount) || 0;
            const formattedAmount = 'PHP ' + amount.toFixed(2);
            
            return [
                '#' + transaction.transaction_id,
                formattedDate,
                itemsList || 'N/A',
                cashierName,
                formattedAmount
            ];
        });
        
        const totalAmount = parseFloat(currentTotalSum) || 0;
        const formattedTotal = 'PHP ' + totalAmount.toFixed(2);
        
        const pageWidth = 297 - 28; 
        const columnWidths = [
            pageWidth * 0.12,  
            pageWidth * 0.20,  
            pageWidth * 0.35,  
            pageWidth * 0.18, 
            pageWidth * 0.15 
        ];
        
        doc.autoTable({
            startY: 32,
            head: [['Transaction ID', 'Date & Time', 'Items', 'Cashier/Admin', 'Total Amount']],
            body: tableData,
            theme: 'striped',
            headStyles: {
                fillColor: [220, 38, 38], 
                textColor: 255,
                fontStyle: 'bold',
                halign: 'center'
            },
            bodyStyles: {
                halign: 'left'
            },
            styles: {
                fontSize: 8,
                cellPadding: 3,
                overflow: 'linebreak',
                cellWidth: 'wrap'
            },
            columnStyles: {
                0: { cellWidth: columnWidths[0], halign: 'left' },
                1: { cellWidth: columnWidths[1], halign: 'left' },
                2: { cellWidth: columnWidths[2], halign: 'left' },
                3: { cellWidth: columnWidths[3], halign: 'left' },
                4: { cellWidth: columnWidths[4], halign: 'right', fontStyle: 'bold' }
            },
            footStyles: {
                fillColor: [245, 245, 245], 
                textColor: 0,
                fontStyle: 'bold'
            },
            foot: [['', '', '', 'TOTAL SUM:', formattedTotal]],
            didDrawPage: function (data) {
                doc.setFontSize(10);
                doc.text(
                    'Page ' + doc.internal.getNumberOfPages(),
                    doc.internal.pageSize.width - 20,
                    doc.internal.pageSize.height - 10
                );
            }
        });
        
        const fileName = 'Transaction_Report_' + new Date().toISOString().split('T')[0] + '.pdf';
        doc.save(fileName);
    }
    
    function formatDateForPdf(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
});