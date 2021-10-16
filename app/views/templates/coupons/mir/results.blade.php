<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr id="tr-<%= r.id %>">
            <td><%= r.id %></td>
            <td><%= r.name %></td>
            <td><%=  r.coupon_type %></td>
            <td><%= r.expires %></td>
            <td><%= r.receive_by %></td>
            
            <td><%= r.user %></td>
            <td><%= r.active %></td>
           
            <td><%= r.created_at %></td>
            {{-- <td><%= r.updated_at %></td> --}}
            <td>
                
                <a href="/admin/coupons/mir/<%= r.id %>/edit"  role="button"><i class="fa fa-pencil"></i> Edit </a> 
                ||
                <a href="javascript:;" class='btndelt' data-id='<%= r.id %>' role="button"><i class="fa fa-trash-o"></i>Delete </a>
            
                
                
        </tr>

    <% }); %>

</script>