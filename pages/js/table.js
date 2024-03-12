fetch('php/fetch_table.php')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#appliances-table tbody');
        data.forEach(item => {
            const row = document.createElement('tr');

            const td1 = document.createElement('td');
            td1.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Item_Type}</p>`;
            row.appendChild(td1);

            const td2 = document.createElement('td');
            td2.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Item_Description}</p>`;
            row.appendChild(td2);

            const td3 = document.createElement('td');
            td3.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Origin}</p>`;
            row.appendChild(td3);

            const td4 = document.createElement('td');
            td4.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Item_Code}</p>`;
            row.appendChild(td4);

            const td5 = document.createElement('td');
            td5.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Uom}</p>`;
            row.appendChild(td5);

            const td6 = document.createElement('td');
            td6.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Quantity}</p>`;
            row.appendChild(td6);

            const td7 = document.createElement('td');
            td7.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Item_Received}</p>`;
            row.appendChild(td7);

            const td8 = document.createElement('td');
            td8.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Date_Of_Delivery}</p>`;
            row.appendChild(td8);

            const td9 = document.createElement('td');
            td9.innerHTML = `<p class="text-xs font-weight-bold mb-0">${item.Expiry_Date}</p>`;
            row.appendChild(td9);

            const td10 = document.createElement('td');
            td10.innerHTML = `
                <div class="d-flex px-2 py-1">
                    <div class="nav-item px-2 d-flex align-items-center">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs">Edit</a>
                    </div>
                    <a href="javascript:;" class="nav-item px-2 d-flex align-items-center">
                        <i class="material-icons opacity-10" id="${item.Item_id}">delete</i>
                    </a>
                </div>
            `;
            row.appendChild(td10);

            td10.querySelector('a').addEventListener('click', function(e) {
                e.preventDefault();

                if (this.innerText === 'Edit') {
                    td1.querySelector('p').contentEditable = "true";
                    td2.querySelector('p').contentEditable = "true";
                    td3.querySelector('p').contentEditable = "true";
                    td4.querySelector('p').contentEditable = "true";
                    td5.querySelector('p').contentEditable = "true";
                    td6.querySelector('p').contentEditable = "true";
                    td7.querySelector('p').contentEditable = "true";
                    td8.querySelector('p').contentEditable = "true";
                    td9.querySelector('p').contentEditable = "true";
                    this.innerText = 'Save';

                } else if (this.innerText === 'Save') {

                    // Capture updated data Item Type 	Item Description 	Origin 	Item Code 	Uom 	Quantity 	Item Received 	Date Of Delivery 	Expiry Date
                    let updated_Item_Type = td1.querySelector('p').innerText;
                    let updated_Item_Description = td2.querySelector('p').innerText;
                    let updated_Origin = td3.querySelector('p').innerText;
                    let updated_Item_Code = td4.querySelector('p').innerText;
                    let updated_Uom = td5.querySelector('p').innerText;
                    let updated_Quantity = td6.querySelector('p').innerText;
                    let updated_Item_Received = td7.querySelector('p').innerText;
                    let updated_Date_Of_Delivery = td8.querySelector('p').innerText;
                    let updated_Expiry_Date = td9.querySelector('p').innerText;

                    // Validate wattage - Ensure it's a number
                    if (isNaN(updated_Quantity) || updated_Quantity.trim() === '') {
                        alert("Please enter a valid number for Quantity.");
                        return;  // Don't proceed further if there's an error
                    }

                    td1.querySelector('p').contentEditable = "false";
                    td2.querySelector('p').contentEditable = "false";
                    td3.querySelector('p').contentEditable = "false";
                    td4.querySelector('p').contentEditable = "false";
                    td5.querySelector('p').contentEditable = "false";
                    td6.querySelector('p').contentEditable = "false";
                    td7.querySelector('p').contentEditable = "false";
                    td8.querySelector('p').contentEditable = "false";
                    td9.querySelector('p').contentEditable = "false";

                    // Send updated data to the server
                    fetch('php/update_item.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `Item_id=${item.Item_id}&Item_Type=${updated_Item_Type}&Item_Description=${updated_Item_Description}&Origin=${updated_Origin}&Item_Code=${updated_Item_Code}&Uom=${updated_Uom}&Quantity=${updated_Quantity}&Item_Received=${updated_Item_Received}&Date_Of_Delivery=${updated_Date_Of_Delivery}&Expiry_Date=${updated_Expiry_Date}`
                    })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                        })
                        .catch(error => console.error('Error:', error));

                    this.innerText = 'Edit';
                }
            });

            // Delete logic
            td10.querySelector('i.material-icons').addEventListener('click', function(e) {
                e.preventDefault();
                let isConfirmed = confirm("Are you sure you want to delete this entry?");
                if (!isConfirmed) {
                    return;
                }

                fetch('php/delete_item.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `Item_id=${item.Item_id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            location.reload()
                        } else {
                            alert('Error deleting the entry. Please try again.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
            tableBody.appendChild(row);
        });
    })
.catch(error => console.error('Error:', error));


