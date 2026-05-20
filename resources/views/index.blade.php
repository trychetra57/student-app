@extends('layouts.app')
@section('title', 'Students — Student Management')
@section('styles')
<style>
.filter-card{background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);padding:20px 24px;margin-bottom:24px;}
.tbl-card{background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;}
.student-avatar{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#60a5fa);display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:.78rem;flex-shrink:0;}
.sort-link{text-decoration:none;color:inherit;display:inline-flex;align-items:center;gap:4px;font-weight:700;font-size:.75rem;}
.sort-link:hover{color:#2563eb;}
.bulk-bar{background:#1e3a8a;border-radius:12px;padding:12px 20px;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:16px;display:none;}
.bulk-bar.visible{display:flex;}
.stat-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:.78rem;font-weight:600;}
.pill-total{background:#eff6ff;color:#1d4ed8;}
.pill-active{background:#dcfce7;color:#15803d;}
.pill-inactive{background:#ffe4e6;color:#be123c;}
.pill-grad{background:#ede9fe;color:#5b21b6;}
</style>
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-users"></i> Students</h1>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('students.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Student</a>
        <a href="{{ route('students.export', request()->query()) }}" class="btn btn-secondary"><i class="fas fa-download"></i> Export CSV</a>
        <form method="POST" action="{{ route('students.delete-all') }}" onsubmit="confirmDelete(event,this,'Delete ALL students?');">
            @csrf @method('DELETE')
            <button class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete All</button>
        </form>
    </div>
</div>

<div class="d-flex gap-2 flex-wrap mb-4">
    <span class="stat-pill pill-total"><i class="fas fa-users"></i> {{ $students->total() }} Total</span>
    <span class="stat-pill pill-active"><i class="fas fa-check-circle"></i> {{ $activeCount }} Active</span>
    <span class="stat-pill pill-inactive"><i class="fas fa-times-circle"></i> {{ $inactiveCount }} Inactive</span>
    <span class="stat-pill pill-grad"><i class="fas fa-graduation-cap"></i> {{ $graduatedCount }} Graduated</span>
</div>

<div class="filter-card">
    <form method="GET" action="{{ route('students.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, phone…" class="form-control border-start-0 ps-0">
                </div>
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status','all')=='all'?'selected':'' }}>All Status</option>
                    <option value="active"    {{ request('status')=='active'   ?'selected':'' }}>Active</option>
                    <option value="inactive"  {{ request('status')=='inactive' ?'selected':'' }}>Inactive</option>
                    <option value="graduated" {{ request('status')=='graduated'?'selected':'' }}>Graduated</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label class="form-label">Grade</label>
                <select name="grade" class="form-select">
                    <option value="">All Grades</option>
                    @foreach($grades as $g)
                        <option value="{{ $g }}" {{ request('grade')==$g?'selected':'' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label class="form-label">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label class="form-label">To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
            </div>
            <div class="col-6 col-sm-3 col-lg-1">
                <label class="form-label">Per page</label>
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    @foreach([10,25,50] as $n)
                        <option value="{{ $n }}" {{ request('per_page',10)==$n?'selected':'' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Clear</a>
        </div>
    </form>
</div>

<div class="bulk-bar" id="bulkBar">
    <form id="bulk-form" method="POST" action="" style="display:none;">@csrf</form>
    <span style="color:#93c5fd;font-weight:600;font-size:.85rem;" id="bulkCount">0 selected</span>
    <select id="bulk-action" class="form-select form-select-sm" style="width:auto;background:#1e3a8a;color:#93c5fd;border-color:#3b82f6;">
        <option value="">Bulk Actions</option>
        <option value="status-active">Set Active</option>
        <option value="status-inactive">Set Inactive</option>
        <option value="status-graduated">Set Graduated</option>
        <option value="delete">Soft Delete</option>
        <option value="force-delete">Permanent Delete</option>
    </select>
    <button id="apply-bulk" class="btn btn-sm" style="background:#2563eb;color:white;"><i class="fas fa-check"></i> Apply</button>
    <button type="button" onclick="clearSel()" class="btn btn-sm" style="background:rgba(255,255,255,.1);color:#93c5fd;"><i class="fas fa-times"></i> Cancel</button>
</div>

<div class="tbl-card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <label class="d-flex align-items-center gap-2 mb-0" style="cursor:pointer;">
            <input type="checkbox" id="select-all" class="form-check-input mt-0">
            <span style="font-size:.82rem;color:#64748b;font-weight:600;">Select All</span>
        </label>
        <span style="font-size:.82rem;color:#94a3b8;">
            {{ $students->firstItem()??0 }}–{{ $students->lastItem()??0 }} of {{ $students->total() }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="40"></th>
                    <th><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'name','direction'=>request('sort')=='name'&&request('direction')=='asc'?'desc':'asc'])) }}">Student <i class="fas fa-sort{{ request('sort')=='name'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'email','direction'=>request('sort')=='email'&&request('direction')=='asc'?'desc':'asc'])) }}">Email <i class="fas fa-sort{{ request('sort')=='email'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th class="d-none d-md-table-cell">Phone</th>
                    <th class="d-none d-lg-table-cell"><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'grade','direction'=>request('sort')=='grade'&&request('direction')=='asc'?'desc':'asc'])) }}">Grade <i class="fas fa-sort{{ request('sort')=='grade'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'status','direction'=>request('sort')=='status'&&request('direction')=='asc'?'desc':'asc'])) }}">Status <i class="fas fa-sort{{ request('sort')=='status'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th class="d-none d-lg-table-cell"><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'created_at','direction'=>request('sort')=='created_at'&&request('direction')=='asc'?'desc':'asc'])) }}">Joined <i class="fas fa-sort{{ request('sort')=='created_at'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($students as $student)
            <tr>
                <td><input type="checkbox" value="{{ $student->id }}" class="form-check-input student-checkbox"></td>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        @if($student->profile_picture_url)
                            <img src="{{ $student->profile_picture_url }}" alt="{{ $student->name }}" class="student-avatar" style="object-fit:cover;">
                        @else
                            <div class="student-avatar">{{ strtoupper(substr($student->name,0,2)) }}</div>
                        @endif
                        <div>
                            <div style="font-weight:600;">{{ $student->name }}</div>
                            <div class="d-lg-none" style="font-size:.75rem;color:#94a3b8;">{{ $student->grade??'—' }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#64748b;">{{ $student->email }}</td>
                <td class="d-none d-md-table-cell" style="color:#64748b;">{{ $student->phone??'—' }}</td>
                <td class="d-none d-lg-table-cell">
                    @if($student->grade)
                        <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;">{{ $student->grade }}</span>
                    @else <span style="color:#cbd5e1;">—</span> @endif
                </td>
                <td>
                    <span class="badge {{ $student->status=='active'?'badge-active':($student->status=='inactive'?'badge-inactive':'badge-graduated') }}">
                        <i class="fas fa-{{ $student->status=='active'?'check-circle':($student->status=='inactive'?'times-circle':'graduation-cap') }}"></i>
                        {{ ucfirst($student->status) }}
                    </span>
                </td>
                <td class="d-none d-lg-table-cell" style="color:#94a3b8;font-size:.8rem;">{{ $student->created_at->format('M j, Y') }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('students.show',$student) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('students.edit',$student) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('students.destroy',$student) }}" class="d-inline" onsubmit="confirmDelete(event,this,'Delete {{ addslashes($student->name) }}?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8">
                <div class="text-center py-5" style="color:#94a3b8;">
                    <i class="fas fa-users fa-3x mb-3" style="opacity:.3;"></i>
                    <p class="mb-0" style="font-weight:600;">No students found</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary mt-3"><i class="fas fa-plus"></i> Add First Student</a>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
    <div class="px-4 py-3 border-top d-flex justify-content-center">
        {{ $students->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const sa=document.getElementById('select-all'),boxes=document.querySelectorAll('.student-checkbox'),
          bar=document.getElementById('bulkBar'),cnt=document.getElementById('bulkCount'),
          bf=document.getElementById('bulk-form'),ba=document.getElementById('bulk-action'),ab=document.getElementById('apply-bulk');
    function checked(){return document.querySelectorAll('.student-checkbox:checked');}
    function upd(){const c=checked();bar.classList.toggle('visible',c.length>0);cnt.textContent=c.length+' selected';sa.checked=c.length===boxes.length&&c.length>0;sa.indeterminate=c.length>0&&c.length<boxes.length;}
    sa.addEventListener('change',function(){boxes.forEach(b=>b.checked=this.checked);upd();});
    boxes.forEach(b=>b.addEventListener('change',upd));
    window.clearSel=function(){boxes.forEach(b=>b.checked=false);ba.value='';upd();};
    function sub(action){
        const c=checked();if(!c.length)return;
        bf.querySelectorAll('input[name="student_ids[]"]').forEach(i=>i.remove());
        c.forEach(cb=>{const i=document.createElement('input');i.type='hidden';i.name='student_ids[]';i.value=cb.value;bf.appendChild(i);});
        let mv='DELETE',url='';
        if(action==='delete')url='{{ route("students.bulk.delete") }}';
        else if(action==='force-delete')url='{{ route("students.bulk.force-delete") }}';
        else if(action.startsWith('status-')){
            mv='PATCH';url='{{ route("students.bulk.status") }}';
            let si=bf.querySelector('input[name="status"]');
            if(!si){si=document.createElement('input');si.type='hidden';si.name='status';bf.appendChild(si);}
            si.value=action.replace('status-','');
        }
        let mi=bf.querySelector('input[name="_method"]');
        if(!mi){mi=document.createElement('input');mi.type='hidden';mi.name='_method';bf.appendChild(mi);}
        mi.value=mv;bf.action=url;bf.submit();
    }
    ab.addEventListener('click',function(){
        const action=ba.value,c=checked();
        if(!action){alert('Select an action.');return;}
        if(!c.length){alert('Select at least one student.');return;}
        if(action==='delete'||action==='force-delete')confirmAction((action==='force-delete'?'PERMANENTLY ':'')+'Delete '+c.length+' student(s)?',()=>sub(action));
        else sub(action);
    });
});
</script>
@endsection
