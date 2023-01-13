@php
    use App\Models\Community;
    use App\Models\User;
@endphp

<script type="text/javascript">
    function clicked() {
       if (confirm('Are you sure you want to delete this post?')) {
           yourformelement.submit();
       } else {
           return false;
       }
    }
</script>

<x-layout>
    <div class="container">
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
              Manage Your Posts
            </h1>
        </header>
    
        <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($posts->isEmpty())
            @foreach($posts as $post)
            @php
                $community = Community::where('id', $post->community_id)->first();
                $username = User::find($post->user_id)->username;
            @endphp
            <tr class="border-gray-300">
            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                <a href="/posts/{{$post->id}}"> {{$post->title}} </a>
            </td>
            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                <a href= "/c/{{ $community['community_name'] }}/{{ $post['id'] }}/edit" class="text-blue-400 px-6 py-2 rounded-xl"><i
                    class="fa-solid fa-pen-to-square"></i>
                Edit</a>
            </td>
            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                <form action="/c/{{ $community['community_name'] }}/{{ $post['id'] }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary fa-solid fa-trash bg-danger p-1 text-light"
                        title="delete" onclick="return confirm('Are you sure you want to delete this post?')"></button>
                </form>
            </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                <p class="text-center">No posts Found</p>
            </td>
            </tr>
            @endunless
    
        </tbody>
        </table>
    </div>
</x-layout>