'use client';
import * as React from "react"
import { Controller, useFieldArray, useForm } from 'react-hook-form';
import { Product } from "@/@types/Product/Product";
import { useEffect, useState } from 'react';
import { createProduct } from '@/lib/services/ProductService';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Input } from '../ui/input';
import { Button } from '../ui/button';
import { ChevronRight, Package, Palette } from 'lucide-react';
import { Label } from '@radix-ui/react-label';
import { Textarea } from '../ui/textarea';
import { getColors } from "@/lib/services/ColorService";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form"
import { Color } from "@/@types/Color/Color";
import { cn } from "@/lib/utils";
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';

interface CreateProductFormProps {
  product?: Product;
  submitTarget: string;
}

export function ProductForm({ product } : { product?: Product}){
    const [colors, setColors] = useState<Color[]>([])

    const sizeSchema = z.object({
        id: z.number().optional(),
        price: z.number().min(1),
        stock: z.string(),
    })

    const productColorSchema = z.object({
        id: z.number().optional(),
        name: z.string().min(1, { message: "O nome não pode estar vazio" }),
        color_id: z.number().gt(0, { message: "Selecione uma Cor" }),
        picture_url: z.string(),
        size_data: z.array(sizeSchema)
    })

    const productSchema = z.object({
        id: z.number().optional(),
        name: z.string().min(1,{ 
            message: "O nome do produto não pode estar vazio" 
        }),
        description: z.string().min(1, { 
            message: "A descrição do produto não pode estar vazia" 
        }),
        product_colors: z.array(productColorSchema)
    })

    const { 
        register,
        control,
        reset, 
        handleSubmit ,
        watch,
        
    } = useForm<Product>({})

    const form = useForm<z.infer<typeof productSchema>>({
        resolver: zodResolver(productSchema),
        defaultValues: {
            name: '',
            description: '',
            product_colors: [
                {
                    name: '',
                    color_id: 0,
                    picture_url: '',
                    size_data: [{ price: 0, stock: '' }],
                },
            ],
        },
    })


    const [tabValue, setTabvalue] = useState<string>("basic-info")

    const onSubmit = async(values: z.infer<typeof productSchema>) => {
        console.log('data')
        console.log(values)
        await createProduct(values)
    }

    const [activeColorIndex, setActiveColorIndex] = useState<number>(0)

    const { fields: colorFields, append: appendColor } = useFieldArray({
        control,
        name: "product_colors"
    })

    
    useEffect(() => {
        console.log('colorindex kkkkkkk', activeColorIndex)
    },[activeColorIndex, setActiveColorIndex])

    useEffect(() => {
        const fetchData = async () => {
            const colorsResponse = await getColors()
            setColors(colorsResponse)

            console.log('corinhasss', colorsResponse)
        }

        fetchData()
        
        console.log('achei');
        // reset(
        //     product 
        //     || 
        //     { 
        //         name: '', 
        //         description: '', 
        //         product_colors: [{}]
        //     }
        // )
    }, [])

    const handleTabValue = (value: string) => {
        setTabvalue(value)
    }

    // const colorValue = watch(`product_colors.${activeColorIndex}.color_id`);
    const {trigger, getValues } = useForm<Product>({})
    // console.log(colorValue);
    return (
        // <div className="flex justify-center h-100">
            <Tabs value={tabValue} onValueChange={setTabvalue} className="flex mt-4 flex-row align-center justify-center h-[100%] w-[100%]">
                <div className="flex flex-row align-center justify-center w-[60%] gap-3">
                    <div className="w-[20%]">
                        <TabsList className="flex flex-col gap-2 w-[100%] h-fit align-start">
                            {/* General information tab option */}
                            <TabsTrigger 
                            value="basic-info"
                            className={cn(
                                "cursor-pointer p-2 w-full flex justify-start font-medium text-gray-600 hover:bg-gray-200 hover:text-gray-900",
                                "data-[state=active]:bg-blue-100 data-[state=active]:text-blue-700 data-[state=active]:font-medium data-[state=active]:border data-[state=active]:border-blue-200",
                                form.formState.errors.name || form.formState.errors.description
                                ? "border-red-500 bg-red-100 hover:bg-red-200"
                                : ""
                            )}
                            >
                                    
                                <Package />
                                Informação geral
                            </TabsTrigger>
                            {/* Variation information tab option */}
                            <TabsTrigger 
                            value="variant-info"
                            className={cn(
                                "cursor-pointer p-2 w-full flex justify-start font-medium text-gray-600 hover:bg-gray-200 hover:text-gray-900",
                                "data-[state=active]:bg-blue-100 data-[state=active]:text-blue-700 data-[state=active]:font-medium data-[state=active]:border data-[state=active]:border-blue-200",
                                form.formState.errors.product_colors
                                ? "border-red-500 bg-red-100 hover:bg-red-200"
                                : ""
                            )}
                            >
                                <Palette />
                                Variantes
                            </TabsTrigger>
                        </TabsList>
                    </div>
                    <Form {...form}>
                        <form className="w-[100%]" onSubmit={form.handleSubmit(onSubmit)}>

                            {/* Basic product info */}
                            <TabsContent value="basic-info">
                                <div className='rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col gap-5 bg-white'>
                                
                                    <FormField
                                        control={form.control}
                                        name="name"
                                        render={({ field }) => (
                                            <FormItem>
                                                <FormLabel>Nome do Produto</FormLabel>
                                                <FormControl>
                                                    <Input placeholder="Digite o nome do produto" {...field} />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        )}
                                    />

                                    <FormField
                                        control={form.control}
                                        name="description"
                                        render={({ field }) => (
                                            <FormItem>
                                                <FormLabel>Descrição</FormLabel>
                                                <FormControl>
                                                    <Textarea className="min-h-[100px] resize-y field-sizing-fixed" placeholder="Descrição detalhada do produto" {...field}/>    
                                                </FormControl>  
                                                <FormMessage />                                              
                                            </FormItem>
                                        )}
                                    />
                                    
                                    <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <div className="flex items-start">
                                        <Package className="h-5 w-5 text-blue-600 mt-0.5 mr-3" />
                                        <div>
                                            <h3 className="text-sm font-medium text-blue-800">Estrutura do Produto</h3>
                                            <p className="text-sm text-blue-700 mt-1">
                                                Esta interface cria produtos com variantes de cor. Cada cor pode informações como tamanhos, imagens e disponibilidade em estoque de forma individual.
                                            </p>
                                        </div>
                                        </div>
                                    </div>

                                </div>    

                                <Button 
                                    onClick={async () => {
                                        const isValid = await trigger(["name", "description"], { shouldFocus: true });
                                        if (isValid) {
                                            handleTabValue("variant-info");
                                        }
                                    }}
                                    className="w-full bg-blue-700 mt-5 gap-0 p-5 hover:bg-blue-800 cursor-pointer">
                                    Avançar
                                    <ChevronRight color="white" />
                                </Button>
                            </TabsContent>

                            {/* Variations product info */}
                            <TabsContent value="variant-info">
                                <div className="w-[100%] rounded-lg shadow-sm border border-red-200 p-6 flex flex-col gap-5 bg-white">
                                    <div className="flex flex-row justify-between">
                                        
                                        <h3 className="font-bold text-lg ">Colors</h3>
                                        <Button
                                            className="w-30 self-end bg-blue-600 cursor-pointer"
                                            type="button"
                                            onClick={() => {
                                                appendColor({
                                                    name: "",
                                                    color_id: 0,
                                                    picture_url: "",
                                                    size_data: [{id: 0, price: 0, stock: ""}]
                                                })
                                            }}
                                            >
                                            Adicionar Cor
                                        </Button>
                                        
                                    </div>
                                    <div className="flex flex-row w-[100%] justify-between gap-7">
                                        <div className="w-[32%] h-fit ">
                                            {/* product color selectors (buttons) */}
                                            {colorFields.map((productColor, productColorIndex) => (
                                                <div className="flex flex-row" key={productColorIndex}>
                                                    <Button
                                                    key={productColorIndex}
                                                    type="button"
                                                    className={cn(
                                                        "w-[100%] p-3 border rounded-lg cursor-pointer transition-colors border-gray-200 bg-white text-black mt-1",
                                                        activeColorIndex === productColorIndex
                                                            ? "border-blue-700 bg-blue-600 text-white"
                                                            : "hover:border-gray-400 hover:bg-white"
                                                    )}
                                                    onClick={() => setActiveColorIndex(productColorIndex)}
                                                    >
                                                        { "Cor " + (productColorIndex + 1) }
                                                    </Button>
                                                </div>
                                            ))}
                                        </div>
                                        <div className="w-[100%]">
                                            {activeColorIndex !== null && colorFields[activeColorIndex] && (
                                                <div key={activeColorIndex} className="w-[100%] flex flex-row justify-between">
                                                    <div className="flex flex-col border rounded-lg w-[100%] gap-3 p-6">
                                                        <div className="flex flex-row w-[100%] justify-between">
                                                            <FormField 
                                                                control={form.control}
                                                                name={`product_colors.${activeColorIndex}.name`}
                                                                render={({ field }) => (
                                                                    <FormItem className="w-[48%]">
                                                                        <FormLabel>Nome da Variante</FormLabel>
                                                                        <FormControl>
                                                                            <Input
                                                                                {...field}
                                                                                value={field.value ?? ""}
                                                                                placeholder="Digite o nome da variante"
                                                                                className="border p-2 w-[100%]"
                                                                            />
                                                                        </FormControl>
                                                                        <FormMessage />
                                                                    </FormItem>
                                                                )}
                                                            />
                                                            
                                                            
                                                            <FormField
                                                                control={form.control}
                                                                name={`product_colors.${activeColorIndex}.color_id`}
                                                                render={({ field }) => (
                                                                    <FormItem className="w-[48%]">
                                                                        <FormLabel>Cor</FormLabel>
                                                                        <Select
                                                                            onValueChange={(value) => field.onChange(Number(value))}
                                                                            value={field.value ? String(field.value) : undefined}
                                                                            defaultValue={undefined}
                                                                        >
                                                                            <FormControl>
                                                                                <SelectTrigger className="w-full">
                                                                                    <SelectValue placeholder="Selecione uma Cor" />
                                                                                </SelectTrigger>
                                                                            </FormControl>
                                                                            <SelectContent>
                                                                                {colors.map((color) => (
                                                                                    <SelectItem key={color.id} value={String(color.id)}>
                                                                                        {color.name}
                                                                                    </SelectItem>
                                                                                ))}
                                                                            </SelectContent>
                                                                        </Select>
                                                                        <FormMessage />
                                                                    </FormItem>
                                                                )}
                                                            />
                                                            
                                                        </div>
                                                        <div className="flex flex-col justify-end">
                                                            <FormField
                                                                control={form.control}
                                                                name={`product_colors.${activeColorIndex}.picture_url`}
                                                                render={({ field }) => (
                                                                    <FormItem>
                                                                        <FormLabel>Fotos do Produto</FormLabel>
                                                                        {/* TODO: refactor when image saving format is set */}
                                                                        <FormControl>
                                                                            <Input
                                                                                placeholder="Foto ueue"
                                                                                className="border p-2 w-full mb-3"
                                                                                {...field}
                                                                            />
                                                                        </FormControl>
                                                                    </FormItem>
                                                                )}
                                                            
                                                            />
                                                            <Button
                                                                className="w-30 self-end bg-green-600 text-xs hover:bg-green-800"
                                                                type="button"
                                                                onClick={() => {
                                                                    appendColor({
                                                                        name: "",
                                                                        color_id: 0,
                                                                        picture_url: "",
                                                                        size_data: [{id: 0, price: 0, stock: ""}]
                                                                    })
                                                                }}
                                                                >
                                                                Adicionar Tamanho
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div> 
                                <Button 
                                    type="submit"
                                    className="w-full mt-5 gap-0 p-6">
                                    Concluir
                                    <ChevronRight color="white" />
                                </Button>
                            </TabsContent>  
                        </form>
                    </Form>
                </div>
            </Tabs>
        // </div>
    );
}