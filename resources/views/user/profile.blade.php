@extends('user.layout')

@section('title', 'My Profile')

@section('content')
<div class="page-header">
    <h2>My Profile</h2>
    <p>Manage your personal information</p>
</div>

<div class="row" style="display: flex; gap: 20px;">
    <div class="col" style="flex: 1;">
        <div style="background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&size=150" 
                    style="width: 150px; height: 150px; border-radius: 50%;" alt="Profile Avatar">
                <h3 style="margin-top: 15px;">{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                
                @if($user->is_instructor)
                <span class="badge" style="background-color: #4A6FDC; color: white; margin-top: 10px;">Instructor</span>
                @endif
                
                @if($user->is_admin)
                <span class="badge" style="background-color: #dc3545; color: white; margin-top: 10px;">Administrator</span>
                @endif
            </div>
            
            <div style="margin-top: 30px;">
                <h4 style="margin-bottom: 15px;">Account Information</h4>
                
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e9ecef;">
                        <span style="color: #6c757d;">Member Since</span>
                        <span style="font-weight: 600;">{{ $user->created_at->format('F d, Y') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e9ecef;">
                        <span style="color: #6c757d;">Last Updated</span>
                        <span style="font-weight: 600;">{{ $user->updated_at->format('F d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col" style="flex: 2;">
        <div style="background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
            <h3 style="margin-bottom: 20px;">Edit Profile</h3>
            
            @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
            @endif
            
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('name')
                    <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; margin-bottom: 5px; font-weight: 600;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    @error('email')
                    <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; margin-bottom: 5px; font-weight: 600;">Password</label>
                    <input type="password" id="password" name="password"
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <span style="color: #6c757d; font-size: 0.9rem;">Leave blank to keep current password</span>
                    @error('password')
                    <span style="color: #dc3545; font-size: 0.9rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: 600;">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div style="margin-top: 30px;">
                    <button type="submit" style="background-color: #4A6FDC; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 