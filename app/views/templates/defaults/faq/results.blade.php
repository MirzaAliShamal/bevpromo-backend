<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.question %></td>
            <td><%=  r.answer %></td>
            <td><a href="/admin/coupons/default-faq/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit </a></td>
        </tr>

    <% }); %>

</script>