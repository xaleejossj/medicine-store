document.addEventListener("DOMContentLoaded", function() {
    actualizarCarrito();

    const botonesAgregar = document.querySelectorAll(".i");
    botonesAgregar.forEach(boton => {
        boton.addEventListener("click", function(e) {
            const producto = e.currentTarget.closest(".pro");
            const nombre = producto.querySelector("h5").innerText;
            const precio = parseFloat(producto.querySelector("h4").innerText.replace('$', '').replace('.', ''));
            agregarAlCarrito(nombre, precio);
        });
    });
});

function agregarAlCarrito(nombre, precio) {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const productoExistente = carrito.find(item => item.nombre === nombre);
    
    if (productoExistente) {
        productoExistente.cantidad++;
    } else {
        carrito.push({ nombre, precio, cantidad: 1 });
    }
    
    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarCarrito();
}

function actualizarCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    const carritoItems = document.getElementById("carrito-items");
    carritoItems.innerHTML = "";

    let total = 0;
    carrito.forEach(item => {
        const itemTotal = item.precio * item.cantidad;
        total += itemTotal;

        const div = document.createElement("div");
        div.classList.add("carrito-item");
        div.innerHTML = `
            <span>${item.nombre} (x${item.cantidad})</span>
            <span>$${itemTotal.toFixed(2)}</span>
        `;
        carritoItems.appendChild(div);
    });

    document.getElementById("total-amount").innerText = total.toFixed(2);
}

function agregarC() {
    alert("Producto agregado al carrito correctamente");
}
