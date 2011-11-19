{config_load file="lang"}

<div align="center">
<table>
  <th>ID</th>
  <th>R&eacute;f&eacute;rence</th>
  <th>Nom</th>
  <th>Description</th>
  <th>Prix</th>
  <th>Categorie</th>
  <th>Action</th>
  {foreach from=$products item=product}
  <tr>
    <td>{$product->product->id}</td>
    <td>{$product->product->reference}</td>
    <td>{$product->product->name}</td>
    <td>{$product->product->description}</td>
    <td>{$product->product->price} &euro;</td>
    <td>{if isset($product->product->category->name)}{$product->product->category->name}{/if}</td>
    <td align="center">
      <form method="POST">
	<input type="hidden" value="{$product->product->id}" name="id" />
	<input type="submit" value="X" name="delete" />
      </form>
    </td>
  </tr>
  {/foreach}
</table>
</div>

{if isset($msg)}
<div class="" align="center">{$msg}</div>
{/if}

<div align="center">
  <form method="POST">
    <input type="submit" name="add_product" value="{#addproduct#}" />
  </form>
</div>
