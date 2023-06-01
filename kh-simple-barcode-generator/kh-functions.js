console.log('KH JS Functions loaded');

function printBarcode(i) {
    let options = {
        'barcodeValue': i.getAttribute("data-barcode-value"),
        'itemName': i.getAttribute("data-item-name"),
        'itemPrice': i.getAttribute("data-item-price")
    }
    
    var win = window.open('about:blank', "_new");
    win.document.open();
    barcodeMarkup = `<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>KH Barcode Generator: Print View</title>
        <style>
            @media print screen{
                body{
                    font-family: sans-serif;
                    font-size:10px;
                    color:black;
                    margin:0px;
                    width:100%;
                }
                p{
                    margin: 3px auto;
                }
                img{
                    width:100%;
                    heigth:auto;
                    margin:0px;
                }
            }
            p{
                margin: 5px auto;
                font-family: sans-serif;
                font-size:12px;
                color:black;
                
            }
        </style>
    </head>
    <body onload="window.print()" onafterprint="window.close()">
        <div>
            <center>
                <p>{item_name} - {item_price}</p>
                <img src="https://barcode.khat.es/api/generate?v={barcode_value}" alt="Generated Barcode">
                <p>{barcode_value}</p>
            </center>
        </div>
    </body>
    </html>`;

    win.document.write(barcodeMarkup.replaceAll('{item_price}',options.itemPrice).replaceAll('{item_name}',options.itemName).replaceAll('{barcode_value}',options.barcodeValue))
    win.document.close();
}