<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffProfileResource\Pages;
use App\Models\StaffProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StaffProfileResource extends Resource
{
    protected static ?string $model = StaffProfile::class;

    protected static ?string $navigationGroup = 'Admin';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Picture')
                    ->schema([
                        // FileUpload component for the profile photo
                        Forms\Components\FileUpload::make('profile_photo_path')
                            ->label('Photo')
                            ->image()
                            ->avatar() // Displays the uploader in a circular "avatar" style
                            ->imageEditor()
                            ->circleCropper()
                            ->disk('public') // Make sure to run `php artisan storage:link`
                            ->directory('staff-photos'),
                    ])->collapsible(),

                Forms\Components\Section::make('Employee Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\Select::make('job_title')
                            ->options([
                                'Doctor' => 'Doctor',
                                'Nurse' => 'Nurse',
                                'Receptionist' => 'Receptionist',
                                'Lab Technician' => 'Lab Technician',
                                'Administrator' => 'Administrator',
                            ])
                            ->required(),

                        Forms\Components\Select::make('department')
                            ->options([
                                'Cardiology' => 'Cardiology',
                                'Orthopedics' => 'Orthopedics',
                                'General Medicine' => 'General Medicine',
                                'Administration' => 'Administration',
                                'Laboratory' => 'Laboratory',
                            ]),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make('Contact Information')
                     ->schema([
                        Forms\Components\TextInput::make('phone_number')
                            ->tel(),
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull(),
                     ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ImageColumn to display the photo in the table
                Tables\Columns\ImageColumn::make('profile_photo_path')
                    ->label('Photo')
                    ->circular(), // Renders the image as a circle

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->badge(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaffProfiles::route('/'),
            'create' => Pages\CreateStaffProfile::route('/create'),
            'edit' => Pages\EditStaffProfile::route('/{record}/edit'),
        ];
    }
}

