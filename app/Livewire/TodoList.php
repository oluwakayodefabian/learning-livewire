<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;
    #[Validate('required|min:3|max:50')]
    public  $name;

    public $search;

    public $editTodoId;

    #[Validate('required|min:3|max:50')]
    public $editTodoName;
    public $editMode = false;

    public function create()
    {
        //! Validate
        $validated = $this->validateOnly('name');

        //! Create the todo
        Todo::create($validated);

        //! clear the input field
        $this->reset('name');

        //! send flash message

        $this->resetPage();
    }

    public function toggle($id)
    {
        $todo = Todo::find($id);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function edit($id)
    {
        $this->editMode = true;
        $todo = Todo::find($id);
        $this->editTodoId = $id;
        $this->editTodoName = $todo->name;
    }

    public function cancelEdit()
    {
        $this->reset(['editMode', 'editTodoId', 'editTodoName']);
    }

    public function update()
    {
        $this->validateOnly('editTodoName');
        Todo::find($this->editTodoId)->update(['name' => $this->editTodoName]);
        $this->cancelEdit();
    }

    public function delete($id)
    {
        /**
         * The try catch block was added just to be able to handle errors more gracefully
         */
        try {
            Todo::findOrFail($id)->delete();
        } catch (\Exception $e) {
            // log($e->getMessage());
            session()->flash('error', 'Something went wrong!: ' . $e->getMessage());
            return;
        }
    }
    public function render()
    {
        return view('livewire.todo-list', ['todos' => Todo::latest()->where('name', 'like', '%' . $this->search . '%')->paginate(5)]);
    }
}
