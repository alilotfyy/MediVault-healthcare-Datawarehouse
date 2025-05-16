document.addEventListener("DOMContentLoaded", fetchData);

function fetchData() {
  fetch("crud.php?action=read")
    .then(res => res.json())
    .then(data => {
      const table = document.getElementById("data-table");
      table.innerHTML = "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
      data.forEach(row => {
        table.innerHTML += `<tr><td>${row.id}</td><td>${row.name}</td><td>${row.email}</td></tr>`;
      });
    });
}

function addCustomer() {
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  fetch("crud.php?action=create", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({ name, email })
  }).then(() => fetchData());
}

function fetchTopCustomers() {
  fetch("queries.php?query=top_customers")
    .then(res => res.json())
    .then(data => {
      const resultDiv = document.getElementById("query-result");
      resultDiv.innerHTML = "<h3>Top 5 Customers</h3><ul>" + 
        data.map(d => `<li>${d.name}: ${d.total_amount} USD</li>`).join("") +
        "</ul>";
    });
}

function fetchExpensiveCategories() {
  const threshold = document.getElementById("threshold").value;
  fetch(`queries.php?query=expensive_categories&threshold=${threshold}`)
    .then(res => res.json())
    .then(data => {
      const resultDiv = document.getElementById("query-result");
      resultDiv.innerHTML = "<h3>Categories Exceeding Threshold</h3><ul>" + 
        data.map(d => `<li>${d.category}: ${d.avg_price} USD</li>`).join("") +
        "</ul>";
    });
}