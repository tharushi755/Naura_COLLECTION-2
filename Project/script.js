document.addEventListener("DOMContentLoaded", function () {
    // Function to fetch updated cart content
    function refreshCart() {
      fetch("update_cart.php")
        .then((response) => response.text())
        .then((data) => {
          document.querySelector(".offcanvas-body").innerHTML = data;
        })
        .catch((error) => console.error("Error refreshing cart:", error));
    }
  
    // Handle quantity updates
    document.addEventListener("change", function (e) {
      if (e.target.classList.contains("update-qty")) {
        const productId = e.target.closest("form").querySelector("[name='update_qty_id']").value;
        const newQuantity = e.target.value;
  
        fetch("update_quantity.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `id=${productId}&quantity=${newQuantity}`,
        })
          .then((response) => response.text())
          .then((data) => {
            if (data === "success") {
              refreshCart(); // Refresh cart after update
            } else {
              console.error("Failed to update quantity");
            }
          })
          .catch((error) => console.error("Error updating quantity:", error));
      }
    });
  
    // Handle product deletion
    document.addEventListener("click", function (e) {
      if (e.target.classList.contains("delete-product")) {
        const productId = e.target.dataset.id;
  
        fetch(`delete_product.php?id=${productId}`, { method: "GET" })
          .then((response) => response.text())
          .then((data) => {
            if (data === "success") {
              refreshCart(); // Refresh cart after deletion
            } else {
              console.error("Failed to delete product");
            }
          })
          .catch((error) => console.error("Error deleting product:", error));
      }
    });
  });
  