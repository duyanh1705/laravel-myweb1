document.addEventListener("submit", function (e) {
    const form = e.target.closest(".form-add-cart");
    if (!form) return;
    e.preventDefault();
    addToCart(form);
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-remove-cart");
    if (!btn) return;
    e.preventDefault();
    removeCart(btn);
});

function addToCart(form) {
    const url = form.action;
    const formData = new FormData(form);

    fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            "Accept": "application/json"
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("HTTP " + res.status);
        return res.json();
    })
    .then(data => {
        const cartCount = document.getElementById("cart-count");
        if (cartCount && data.cartCount !== undefined) {
            cartCount.innerText = data.cartCount;
        }
        alert(data.message);
    })
    .catch(err => {
        console.error("Lỗi:", err);
        alert("Có lỗi xảy ra khi thêm vào giỏ hàng!");
    });
}

function removeCart(btn) {
    if (!confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        return;
    }

    const url = btn.dataset.url;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    fetch(url, {
        method: "DELETE",
        headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrfToken
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("HTTP " + res.status);
        return res.json();
    })
    .then(data => {
        if (!data.status) {
            alert(data.message);
            return;
        }

        // Xóa dòng sản phẩm
        btn.closest("tr").remove();

        // Cập nhật số lượng trên Navbar
        const cartCount = document.getElementById("cart-count");
        if (cartCount) cartCount.innerText = data.cartCount;

        // Cập nhật tổng số lượng
        const totalQuantity = document.getElementById("totalQuantity");
        if (totalQuantity) totalQuantity.innerText = data.cartCount;

        // Cập nhật tổng tiền
        const total = document.getElementById("total");
        if (total) {
            total.innerText = Number(data.total).toLocaleString("vi-VN") + " đ";
        }

        // Nếu trống thì reload
        if (data.isEmpty) {
            location.reload();
        }
    })
    .catch(err => {
        console.error(err);
        alert("Có lỗi xảy ra khi xóa sản phẩm!");
    });
}