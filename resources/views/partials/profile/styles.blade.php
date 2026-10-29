<style>
    .profile-page { padding-bottom: 3rem; }
    .profile-hero {
        background: linear-gradient(135deg, #323D7E 0%, #0099CC 100%);
        color: #fff; border-radius: .75rem; padding: 1.5rem 1.75rem;
        display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;
    }
    .profile-hero .avatar {
        width: 88px; height: 88px; border-radius: 50%; overflow: hidden; flex: none;
        border: 4px solid rgba(255,255,255,.85); background: #fff; color: #323D7E;
        display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700;
    }
    .profile-hero .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-hero h1 { font-size: 1.5rem; margin: 0; font-weight: 700; }
    .profile-hero .meta { opacity: .9; font-size: .9rem; }
    .profile-hero .btn-cv { margin-left: auto; }

    .profile-nav { position: sticky; top: 6rem; }
    .profile-nav .card { border: 0; border-radius: .75rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    .profile-nav .progress { height: .6rem; border-radius: 1rem; }
    .profile-nav .progress-bar { background: #D88F32; }
    .profile-nav ul { list-style: none; margin: 0; padding: 0; }
    .profile-nav li a { display: flex; align-items: center; gap: .6rem; padding: .35rem 0; color: #444; font-size: .9rem; }
    .profile-nav li a:hover { color: #0099CC; text-decoration: none; }
    .profile-nav .dot { width: 1.1rem; text-align: center; color: #c5c5c5; }
    .profile-nav .done .dot { color: #28a745; }

    .p-card { border: 0; border-radius: .75rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); margin-bottom: 1.5rem; scroll-margin-top: 6rem; }
    .p-card > .card-header {
        background: #fff; border-bottom: 1px solid #eee; border-radius: .75rem .75rem 0 0;
        display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem;
    }
    .p-card .card-header h2 { font-size: 1.1rem; margin: 0; font-weight: 700; color: #323D7E; }
    .p-card .card-header h2 i { color: #0099CC; width: 1.5rem; }
    .p-card .form-group label { font-size: .8rem; font-weight: 600; color: #6B6B6B; margin-bottom: .25rem; }
    .p-card .form-control { border-radius: .4rem; }
    .p-card .form-control:focus { border-color: #0099CC; box-shadow: 0 0 0 .15rem rgba(0,153,204,.2); }
    .p-card .add-form { background: #f8f9fb; border-radius: .6rem; padding: 1rem; margin-bottom: 1rem; }

    .p-item { display: flex; gap: 1rem; padding: .9rem 0; border-bottom: 1px solid #f0f0f0; }
    .p-item:last-child { border-bottom: 0; }
    .p-item .icon { flex: none; width: 2.4rem; height: 2.4rem; border-radius: 50%; background: #e8f5fa; color: #0099CC; display: flex; align-items: center; justify-content: center; }
    .p-item .body { flex: 1; min-width: 0; }
    .p-item h3 { font-size: 1rem; margin: 0; font-weight: 700; }
    .p-item .sub { color: #6B6B6B; font-size: .85rem; }
    .p-item .desc { margin: .4rem 0 0; font-size: .9rem; color: #444; white-space: pre-line; }
    .p-item .actions { flex: none; white-space: nowrap; }
    .p-item .actions a { color: #9a9a9a; padding: .25rem .4rem; }
    .p-item .actions a:hover { color: #0099CC; }
    .p-item .actions a.erase-experience:hover, .p-item .actions a.erase-education:hover, .p-item .actions a.erase-reference:hover { color: #dc3545; }
    .p-empty { color: #9a9a9a; text-align: center; padding: 1rem 0; font-size: .9rem; }

    .skill-pill { display: inline-flex; align-items: center; gap: .4rem; background: #e8f5fa; color: #1a6b8a; border-radius: 2rem; padding: .35rem .8rem; margin: 0 .4rem .5rem 0; font-size: .85rem; font-weight: 600; cursor: pointer; transition: background .15s; }
    .skill-pill:hover { background: #fde8e8; color: #b02a37; }
    .skill-pill i { font-size: .7rem; opacity: .6; }

    @media (max-width: 991px) { .profile-nav { position: static; margin-bottom: 1.5rem; } .profile-hero .btn-cv { margin-left: 0; } }
</style>
<style>
    .photo-upload { display: flex; gap: 1.25rem; align-items: center; padding: 1rem; margin-bottom: 1.25rem; border-radius: .6rem; background: #f8f9fb; border: 1px solid #eef0f4; }
    .photo-upload--empty { background: #fff8ec; border: 1px dashed #D88F32; }
    .photo-upload__preview { flex: none; width: 96px; height: 96px; border-radius: 50%; overflow: hidden; background: #e9ecf3; color: #323D7E; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; border: 3px solid #fff; box-shadow: 0 0 0 1px #d6dae5; }
    .photo-upload__preview img { width: 100%; height: 100%; object-fit: cover; }
    .photo-upload__body { flex: 1; min-width: 0; font-size: .9rem; }
    .photo-upload__input { max-width: 320px; }
    .custom-file-label::after { content: "Elegir"; }
    .photo-tip { background: rgba(255,255,255,.18); border-radius: .5rem; padding: .4rem .75rem; font-size: .85rem; margin-top: .6rem; display: inline-block; }
    .photo-tip a { color: #fff; text-decoration: underline; font-weight: 600; }
    @media (max-width: 575px) { .photo-upload { flex-direction: column; text-align: center; } }
</style>
