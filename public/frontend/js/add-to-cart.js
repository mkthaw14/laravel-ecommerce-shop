
$(document).ready(function() {
    createLocalStorage();
    //updateCartUI(showByQuantity);
    showCartItems();

    $("#product-section").on("click", ".add-to-cart", function(e) {
        e.preventDefault();
        //alert("click");
        addToCart(this);
        updateCartUI(showByQuantity);
    });

    $(document).on("click", ".substract-btn", function(e) {
        e.preventDefault();
        //alert("click");
        substractItem($(this).data("index"), JSON.parse(localStorage.getItem(storageKey)));
    });

    $(document).on("click", ".add-btn", function(e) {
        e.preventDefault();
        //alert("click");
        addItem($(this).data("index"), JSON.parse(localStorage.getItem(storageKey)));
    });

    $("#cart-table").on("click", ".remove-cart-item-btn" , function(e) {
        e.preventDefault();
        console.log("click remove btn");
        removeStoredItem($(this).data("index"), JSON.parse(localStorage.getItem(storageKey)));
        showCartItems();
        updateCartUI(showByQuantity);
    })
});

function createLocalStorage()
{
    let items = localStorage.getItem(storageKey);

    if(!items)
    {
        items = [];
        localStorage.setItem(storageKey, JSON.stringify(items));
    }
    console.log(items);
}

function addToCart(el)
{
    let newItem = {
        id : $(el).data("id"),
        name : $(el).data("name"),
        img : 'http://localhost:8000/' + $(el).data("img"),
        price : $(el).data("price"),
        qty : 1
    };

    let storedItems = JSON.parse(localStorage.getItem(storageKey));
    let itemIndex = findItem(storedItems, newItem);

    if(itemIndex != -1)
    {
        storedItems[index].qty++;
    }
    else
    {
        storedItems.push(newItem);
    }

    localStorage.setItem(storageKey, JSON.stringify(storedItems));


    console.log(newItem);
}

function findItem(items, newItem)
{
    index = -1;
    for(let i = 0; i < items.length; i++)
    {
        if(items[i].id == newItem.id)
        {
            console.log(items[i].id);
            index = i;
            break;
        }
    }

    return index;
}




function showCartItems()
{
    let storedItems = JSON.parse(localStorage.getItem(storageKey));
    let rows = '';
    storedItems.forEach(function(item, index) {
        rows += `
            <tr>
                <td style="height: 120px;">${item.id}</td>
                <td style="height: 120px;"><img src="${item.img}" alt="${item.img}" height="120px"></td>
                <td style="height: 120px;">${item.name}</td>
                <td style="height: 120px;">${item.price}</td>
                <td style="height: 120px;">
                    <div class="d-flex">
                    <a class="substract-btn text-dark" data-index="${index}"><i data-feather="minus-square"></i></a>
                        <span class="mx-2" id=item-${index}>${item.qty}</span>
                    <a class="add-btn text-dark" data-index="${index}"><i data-feather="plus-square"></i></a>
                    </div>
                </td>
                <td style="height: 120px;"><a href="" data-index="${index}" class="remove-cart-item-btn text-dark">    <!-- From feather icon -->
                <i data-feather="x-square"></i></a></td>
            </tr>
        `;
    });

    $("#cart-table").html(rows);
    feather.replace();

    if(storedItems.length > 0)
        showCartFooter();
    else
        hideCartFooter();
}

function removeStoredItem(index, storedItems)
{
    storedItems.splice(index, 1);
    localStorage.setItem(storageKey, JSON.stringify(storedItems));
}

function showCartFooter()
{
    let storedItems = JSON.parse(localStorage.getItem(storageKey));
    let total = findTotalAmount(storedItems);
    let footer = `
        <tr>
            <th colspan="4">Total</th>
            <th colspan="1" class="text-center">$${total}</th>
            <th colspan="1"><a class="btn btn-dark" id="check-out-btn" href="${checkOutRoute}">CheckOut</a></th>
        </tr>
    `;

    $("#cart-footer").html(footer);
}

function hideCartFooter()
{
    $("#cart-footer").html('');
}

function findTotalAmount(storedItems)
{
    let total = 0;
    storedItems.forEach(function(item, index) {
        total += item.price * item.qty;
    });

    return total;
}

function substractItem(index, storedItems)
{
    if(storedItems[index].qty < 2)
        return;

    storedItems[index].qty--;
    localStorage.setItem(storageKey, JSON.stringify(storedItems));
    showCartFooter();
    updateItemQty(index, storedItems);

}

function addItem(index, storedItems)
{
    if(storedItems[index].qty > 98)
        return;

    storedItems[index].qty++;
    localStorage.setItem(storageKey, JSON.stringify(storedItems));
    showCartFooter();
    updateItemQty(index, storedItems);
}

function updateItemQty(index, storedItems)
{
    $("#item-" + index).text(storedItems[index].qty);
}
