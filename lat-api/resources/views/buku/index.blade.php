<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="bg-light">
    <main class="container">
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            
            {{-- ketika error  --}}
                {{--$errors->any() artinya adalah jika ada eror ketika mengisi form maka akan muncul alert --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            {{-- errors->all() digunakan untuk mengambil semua eror,error dalam bentuk array oleh sebab itu harus dilakukan foreach akan diproses satu satu  --}}
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            {{-- akhir kerika error  --}}


            {{-- ketika succes  --}}
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            {{-- akhir ketika success --}}


            <form action='' method='post'>
                @csrf 

                {{-- put diberikan agar dapat melakukan update data  --}}
                @if (Route::current()->uri == 'buku/{id}')
                    @method('put')
                @endif 

                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='judul' id="judul" value="{{ $data['judul'] ?? old('judul') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Pengarang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='pengarang' id="pengarang" value="{{ $data['pengarang'] ?? old('pengarang') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal_publikasi" class="col-sm-2 col-form-label">Tanggal Publikasi</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control w-50" name='tanggal_publikasi' value="{{ $data['tanggal_publikasi'] ?? old('tanggal_publikasi') }}" id="tanggal_publikasi">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        {{-- ini hanya akan tampil ketika route nya '/buku' , jadi jika '/buku/12' maka tidak akan tampil  --}}
        @if (Route::current()->uri == 'buku')
            <!-- START DATA -->
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-4">Judul</th>
                            <th class="col-md-3">Pengarang</th>
                            <th class="col-md-2">Tanggal Publikasi</th>
                            <th class="col-md-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $i }} </td>
                                <td>{{ $item['judul'] }}</td>
                                <td>{{ $item['pengarang'] }}</td>
                                <td>{{ date('d/m/Y' , strtotime($item['tanggal_publikasi'])) }}</td>
                                <td>
                                    <a href="/buku/{{$item['id']  }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="/buku/{{$item['id']  }}" method="post" onsubmit="return confirm('apakah kamu yakin ingin menghapus data?')" class="d-inline">
                                        @csrf 
                                        @method('delete')
                                        <button type="submit" name="submit" class="btn btn-danger btn-sm">Del</button>
                                    
                                    </form>
                                </td>
                            </tr>
                            <?php $i++?>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <!-- AKHIR DATA -->
        @endif
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>