const products = document.getElementById('products');

if(products){
    products.addEventListener('click',(e)=>{
        if(e.target.className ==='btn btn-sm btn-danger btn-outline-secondary delete-products'){
            if(confirm("Are you sure ?")){
                const id = e.target.getAttribute('data-id');

                fetch('products/delete/'+id,{
                    method:'DELETE'
                }).then(res => window.location.reload());
            }
        }
    })
}