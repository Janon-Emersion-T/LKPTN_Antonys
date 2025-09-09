<x-layouts.customer.app :title="__('My Profile')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <!-- Page Header -->
        <div>
            <flux:heading size="xl">My Profile</flux:heading>
            <flux:text class="text-neutral-600 dark:text-neutral-400">
                Manage your account information and preferences
            </flux:text>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Profile Information Form -->
            <div class="lg:col-span-2">
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-6">Profile Information</flux:heading>
                    
                    <form 
                        x-data="profileForm()" 
                        @submit.prevent="updateProfile()"
                        class="space-y-6"
                    >
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <flux:field>
                                    <flux:label>Full Name</flux:label>
                                    <flux:input 
                                        name="name" 
                                        value="{{ $customer->name }}" 
                                        x-model="form.name"
                                        required 
                                    />
                                    <flux:error name="name" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Email Address</flux:label>
                                    <flux:input 
                                        type="email" 
                                        name="email" 
                                        value="{{ $customer->email }}" 
                                        x-model="form.email"
                                        required 
                                    />
                                    <flux:error name="email" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Phone Number</flux:label>
                                    <flux:input 
                                        name="phone" 
                                        value="{{ $customer->phone }}" 
                                        x-model="form.phone"
                                    />
                                    <flux:error name="phone" />
                                </flux:field>
                            </div>

                            <div>
                                <flux:field>
                                    <flux:label>Date of Birth</flux:label>
                                    <flux:input 
                                        type="date" 
                                        name="date_of_birth" 
                                        value="{{ $customer->date_of_birth?->format('Y-m-d') }}" 
                                        x-model="form.date_of_birth"
                                    />
                                    <flux:error name="date_of_birth" />
                                </flux:field>
                            </div>
                        </div>

                        <div>
                            <flux:field>
                                <flux:label>Gender</flux:label>
                                <flux:select name="gender" x-model="form.gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ $customer->gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $customer->gender === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $customer->gender === 'other' ? 'selected' : '' }}>Other</option>
                                </flux:select>
                                <flux:error name="gender" />
                            </flux:field>
                        </div>

                        <!-- Address Fields -->
                        <div class="border-t pt-6">
                            <flux:heading size="sm" class="mb-4">Address Information</flux:heading>
                            
                            <div class="space-y-4">
                                <flux:field>
                                    <flux:label>Address Line 1</flux:label>
                                    <flux:input 
                                        name="address_line_1" 
                                        value="{{ $customer->address_line_1 }}" 
                                        x-model="form.address_line_1"
                                    />
                                    <flux:error name="address_line_1" />
                                </flux:field>

                                <flux:field>
                                    <flux:label>Address Line 2</flux:label>
                                    <flux:input 
                                        name="address_line_2" 
                                        value="{{ $customer->address_line_2 }}" 
                                        x-model="form.address_line_2"
                                    />
                                    <flux:error name="address_line_2" />
                                </flux:field>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <flux:field>
                                        <flux:label>City</flux:label>
                                        <flux:input 
                                            name="city" 
                                            value="{{ $customer->city }}" 
                                            x-model="form.city"
                                        />
                                        <flux:error name="city" />
                                    </flux:field>

                                    <flux:field>
                                        <flux:label>State/Province</flux:label>
                                        <flux:input 
                                            name="state" 
                                            value="{{ $customer->state }}" 
                                            x-model="form.state"
                                        />
                                        <flux:error name="state" />
                                    </flux:field>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <flux:field>
                                        <flux:label>Postal Code</flux:label>
                                        <flux:input 
                                            name="postal_code" 
                                            value="{{ $customer->postal_code }}" 
                                            x-model="form.postal_code"
                                        />
                                        <flux:error name="postal_code" />
                                    </flux:field>

                                    <flux:field>
                                        <flux:label>Country</flux:label>
                                        <flux:input 
                                            name="country" 
                                            value="{{ $customer->country ?? 'Sri Lanka' }}" 
                                            x-model="form.country"
                                        />
                                        <flux:error name="country" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <flux:button 
                                type="submit" 
                                :disabled="loading"
                                x-bind:disabled="loading"
                            >
                                <span x-show="!loading">Update Profile</span>
                                <span x-show="loading">Updating...</span>
                            </flux:button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="mt-6 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-6">Change Password</flux:heading>
                    
                    <form 
                        x-data="passwordForm()" 
                        @submit.prevent="updatePassword()"
                        class="space-y-6"
                    >
                        <div class="space-y-4">
                            <flux:field>
                                <flux:label>Current Password</flux:label>
                                <flux:input 
                                    type="password" 
                                    name="current_password" 
                                    x-model="passwordData.current_password"
                                    required 
                                />
                                <flux:error name="current_password" />
                            </flux:field>

                            <flux:field>
                                <flux:label>New Password</flux:label>
                                <flux:input 
                                    type="password" 
                                    name="password" 
                                    x-model="passwordData.password"
                                    required 
                                />
                                <flux:error name="password" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Confirm New Password</flux:label>
                                <flux:input 
                                    type="password" 
                                    name="password_confirmation" 
                                    x-model="passwordData.password_confirmation"
                                    required 
                                />
                                <flux:error name="password_confirmation" />
                            </flux:field>
                        </div>

                        <div class="flex justify-end">
                            <flux:button 
                                type="submit" 
                                variant="outline"
                                x-bind:disabled="passwordLoading"
                            >
                                <span x-show="!passwordLoading">Change Password</span>
                                <span x-show="passwordLoading">Changing...</span>
                            </flux:button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Profile Summary Sidebar -->
            <div class="space-y-6">
                <!-- Account Summary -->
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-4">Account Summary</flux:heading>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Member Since</flux:text>
                            <flux:text class="text-sm font-medium">{{ $customer->created_at->format('M Y') }}</flux:text>
                        </div>
                        <div class="flex items-center justify-between">
                            <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Email Status</flux:text>
                            @if($customer->email_verified_at)
                                <flux:badge size="sm" class="bg-green-100 text-green-800">Verified</flux:badge>
                            @else
                                <flux:badge size="sm" class="bg-yellow-100 text-yellow-800">Unverified</flux:badge>
                            @endif
                        </div>
                        <div class="flex items-center justify-between">
                            <flux:text class="text-sm text-neutral-600 dark:text-neutral-400">Account Type</flux:text>
                            <flux:text class="text-sm font-medium">Customer</flux:text>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-zinc-900">
                    <flux:heading size="sm" class="mb-4">Quick Actions</flux:heading>
                    
                    <div class="space-y-2">
                        <flux:button :href="route('customer.orders')" variant="ghost" size="sm" class="w-full justify-start" wire:navigate>
                            <flux:icon.shopping-bag class="mr-2 h-4 w-4" />
                            View Orders
                        </flux:button>
                        <flux:button :href="route('customer.wishlist')" variant="ghost" size="sm" class="w-full justify-start" wire:navigate>
                            <flux:icon.heart class="mr-2 h-4 w-4" />
                            My Wishlist
                        </flux:button>
                        <flux:button :href="route('products.index')" variant="ghost" size="sm" class="w-full justify-start" wire:navigate>
                            <flux:icon.squares-plus class="mr-2 h-4 w-4" />
                            Browse Products
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function profileForm() {
            return {
                loading: false,
                form: {
                    name: '{{ $customer->name }}',
                    email: '{{ $customer->email }}',
                    phone: '{{ $customer->phone }}',
                    date_of_birth: '{{ $customer->date_of_birth?->format('Y-m-d') }}',
                    gender: '{{ $customer->gender }}',
                    address_line_1: '{{ $customer->address_line_1 }}',
                    address_line_2: '{{ $customer->address_line_2 }}',
                    city: '{{ $customer->city }}',
                    state: '{{ $customer->state }}',
                    postal_code: '{{ $customer->postal_code }}',
                    country: '{{ $customer->country ?? 'Sri Lanka' }}'
                },
                
                async updateProfile() {
                    this.loading = true;
                    
                    try {
                        const response = await fetch('{{ route('customer.profile.update') }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.form)
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            alert('Profile updated successfully!');
                        } else {
                            alert('Error updating profile. Please try again.');
                        }
                    } catch (error) {
                        alert('Error updating profile. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }

        function passwordForm() {
            return {
                passwordLoading: false,
                passwordData: {
                    current_password: '',
                    password: '',
                    password_confirmation: ''
                },
                
                async updatePassword() {
                    this.passwordLoading = true;
                    
                    try {
                        const response = await fetch('{{ route('customer.profile.update') }}', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.passwordData)
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            alert('Password changed successfully!');
                            this.passwordData = {
                                current_password: '',
                                password: '',
                                password_confirmation: ''
                            };
                        } else {
                            alert('Error changing password. Please check your current password and try again.');
                        }
                    } catch (error) {
                        alert('Error changing password. Please try again.');
                    } finally {
                        this.passwordLoading = false;
                    }
                }
            }
        }
    </script>
</x-layouts.customer.app>