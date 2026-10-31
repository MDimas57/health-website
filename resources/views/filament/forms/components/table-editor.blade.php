<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

<div
x-data="{

    state: $wire.$entangle(@js($getStatePath())),

    init(){

        if(!this.state){

            this.state = {

                headers:[
                    'Kolom 1',
                    'Kolom 2',
                    'Kolom 3'
                ],

                rows:[
                    ['', '', ''],
                    ['', '', ''],
                    ['', '', '']
                ]

            }

        }

    },


addRow(){

    this.state.rows.push(

        new Array(
            this.state.headers.length
        ).fill('')

    )

},


removeRow(index){

    if(this.state.rows.length <= 1){

        return;

    }


    this.state.rows.splice(index,1)

},


addColumn(){

    this.state.headers.push(
        'Kolom ' +
        (this.state.headers.length + 1)
    )


    this.state.rows.forEach(row=>{

        row.push('')

    })

},
            removeColumn(index){

            if(this.state.headers.length <= 1){

                return;

            }


            this.state.headers.splice(index,1);


            this.state.rows.forEach(row => {

                row.splice(index,1);

            });

        },


    updateHeader(index,value){

        this.state.headers[index]=value

    }


}"

>


<div class="flex gap-2 mb-4">


<button
type="button"
class="px-3 py-2 rounded bg-primary-600 text-white"
@click="addRow()"
>
+ Baris
</button>


<button
type="button"
class="px-3 py-2 rounded bg-primary-600 text-white"
@click="addColumn()"
>
+ Kolom
</button>


</div>



<table class="w-full border">


<thead>

<tr>
<thead>

<tr>


<template
x-for="(header,index) in state.headers"
:key="index"
>

<th class="border p-2">

<div class="flex items-center gap-2">


<input

type="text"

x-model="state.headers[index]"

class="w-full font-bold"


>


<button

type="button"

class="text-danger-600"

@click="removeColumn(index)"

>

🗑️

</button>


</div>

</th>

</template>


<th class="border p-2">
Aksi
</th>


</tr>

</thead>



<tbody>

<template
x-for="(row,rowIndex) in state.rows"
:key="rowIndex"
>

<tr>


<template
x-for="(cell,colIndex) in row"
:key="colIndex"
>

<td class="border p-2">

<input

type="text"

x-model="state.rows[rowIndex][colIndex]"

class="w-full"

>

</td>


</template>


<td class="border p-2 text-center">

<button

type="button"

@click="removeRow(rowIndex)"

>

🗑️

</button>

</td>


</tr>


</template>


</tbody>


</table>


</div>


</x-dynamic-component>