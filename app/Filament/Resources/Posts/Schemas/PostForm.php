<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Schemas\Components\Section;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                // Section 1: Post Details
                Section::make('Post Details')
                    ->description('Fill in the details of the post')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        //grouping fields into 2 columns
                        Group::make([
                            TextInput::make('title')
                                ->rules(["required", "min:5"])
                                ->validationMessages([
                                    'required' => 'Title wajib diisi!',
                                    'min' => 'Title minimal 5 karakter.',
                                ]),
                            TextInput::make('slug')
                                ->rules(["required", "min:3"])
                                ->unique()
                                ->validationMessages([
                                    'unique' => 'Slug Harus Unik Boss!!!',
                                    'min' => 'Slug minimal 3 karakter.',
                                ]),
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->preload()
                                ->searchable()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Category wajib dipilih!',
                                ]),
                            ColorPicker::make('color'),
                        ])->columns(2),
                        MarkdownEditor::make('content'),
                    ])->columnSpan(2),

                //grouping fields into 2 columns
                Group::make([

                    //Section 2: image
                    Section::make('Image Upload')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('posts')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Image wajib diupload!',
                                ]),
                        ]),
                    //Section 3: meta
                    Section::make('Meta Information')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            //TagsInput::make('tags'),
                            Select::make('tags')
                                ->relationship('tags', 'name')
                                ->multiple()
                                ->preload(),
                            Checkbox::make('published'),
                            DateTimePicker::make('published_at')
                        ]),
                ])->columnSpan(1)
            ])->columns(3);
    }
}
