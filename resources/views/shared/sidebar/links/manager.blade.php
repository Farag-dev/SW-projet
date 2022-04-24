{{-- manager tasks --}}
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
    <div class="sb-nav-link-icon"><i class="fas fa-solid fa-user-tie"></i></div>
    Managers
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
        <a class="nav-link" href="{{route('managers.index')}}">List All Managers</a>
        <a class="nav-link" href="{{route('managers.create')}}">Add Manager</a>
    </nav>
</div>

{{-- Manager task --}}
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
    <div class="sb-nav-link-icon"><i class="fas fa-solid fa-users"></i></div>
    Staff
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
            Doctors
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('doctor') }}">List All Doctors</a>
                <a class="nav-link" href="{{ route('add.doctor') }}">Add Doctor</a>
            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"  data-bs-target="#pagesCollapseAssistent" aria-expanded="false" aria-controls="pagesCollapseAssistent" >
            Assistant
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="pagesCollapseAssistent" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('assistant') }}">List All Assistants</a>
                <a class="nav-link" href="{{ route('add.assistant') }}">Add Assistant</a>
            </nav>
        </div>

        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"  data-bs-target="#collapseAccountant" aria-expanded="false" aria-controls="collapseAccountant" >
            Accountant
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseAccountant" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('accountant') }}">List All Accountants</a>
                <a class="nav-link" href="{{ route('add.accountant') }}">Add Accountant</a>
            </nav>
        </div>
    </nav>
</div>
