{config_load file="lang"}

<div align="center">
  <table>
    <form method="POST">
      <tr>
	<td>Nom</td>
	<td><input type="text" value="{if isset($product.name)}{$product.name}{/if}" name="name" /></td>
      </tr>
      <tr>
	<td>Description</td>
	<td><input type="text" value="{if isset($product.description)}{$product.description}{/if}" name="description" /></td>
      </tr>
      <tr>
	<td>Prix</td>
	<td><input type="text" value="{if isset($product.price)}{$product.price}{/if}" name="price" /> &euro;</td>
      </tr>
      <tr>
	<td>Nombre d'&eacute;l&eacute;ments</td>
	<td><input type="text" value="{if isset($product.stocks)}{$product.stocks}{/if}" name="stocks" /></td>
      </tr>
      <tr>
	<td>Action</td>
	<td><input type="submit" name="add_this_product" value="{#add#}" /></td>
      </tr>
    </form>
  </table>
</div>

{if isset($message)}
<div class="" align="center">{$message}</div>
{/if}
