{config_load file="lang"}

<div align="center">
<table>
  <th>ID</th>
  <th>R&eacute;f&eacute;rence client</th>
  <th>Pr&eacute;nom</th>
  <th>Nom</th>
  <th>Status</th>
  <th>E-mail</th>
  <th>Action</th>
  {foreach from=$users item=user}
  <tr>
    <td>{$user->user->id}</td>
    <td>{$user->user->reference_client}</td>
    <td>{$user->user->first_name}</td>
    <td>{$user->user->last_name}</td>
    <td>{$user->user->status}</td>
    <td>{$user->user->email}</td>
    <td align="center">
      <form method="POST">
	<input type="hidden" value="{$user->user->id}" name="id" />
	<input type="submit" value="X" name="delete" />
      </form>
    </td>
  </tr>
  {/foreach}
</table>
</div>

{if isset($message)}
<div class="" align="center">{$messge}</div>
{/if}

<div align="center">
  <form method="POST">
    <input type="submit" name="add_user" value="{#adduser#}" />
  </form>
</div>

