$(document).ready(function(){
    $(document).on( 'click',"#itemQuantity",function(){
        var $element = $(this).closest('#result');
        var productPrice = $element.find("#productPrice").val();
        var itemQuantity = $element.find("#itemQuantity").val();
        var productId    = $element.find("#productId").val();
        event.preventDefault();
        location.reload(true);
        $.ajax({
            url: "shopping_cart.php",
            data: {Price:productPrice,Quantity:itemQuantity,productID:productId},
            method: 'POST',
            success: function (data){
                $("#result").html(data);
            }
        })
    });
});