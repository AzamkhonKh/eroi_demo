<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarketingExpenseResource\Pages;
use App\Models\MarketingExpense;
use App\Models\TrafficSource;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MarketingExpenseResource extends Resource
{
    protected static ?string $model = MarketingExpense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Marketing Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('traffic_source_id')
                    ->label('Traffic Source')
                    ->options(TrafficSource::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01),

                Forms\Components\DatePicker::make('expense_date')
                    ->required()
                    ->default(now())
                    ->maxDate(now()),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull()
                    ->rows(3),

                Forms\Components\Hidden::make('created_by')
                    ->default(fn () => Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trafficSource.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('notes')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    }),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('traffic_source_id')
                    ->label('Traffic Source')
                    ->options(TrafficSource::pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\Filter::make('expense_date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->placeholder(fn ($state): string => 'Dec 18, '.now()->subYear()->format('Y')),
                        Forms\Components\DatePicker::make('date_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('expense_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['date_from'] ?? null) {
                            $indicators['date_from'] = 'Expense from '.Carbon::parse($data['date_from'])->toFormattedDateString();
                        }
                        if ($data['date_until'] ?? null) {
                            $indicators['date_until'] = 'Expense until '.Carbon::parse($data['date_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('expense_date', 'desc');
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
            'index' => Pages\ListMarketingExpenses::route('/'),
            'create' => Pages\CreateMarketingExpense::route('/create'),
            'edit' => Pages\EditMarketingExpense::route('/{record}/edit'),
        ];
    }
}
