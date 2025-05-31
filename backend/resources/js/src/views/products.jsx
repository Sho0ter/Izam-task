// src/pages/ProductsPage.js
import React, { useEffect, useState } from 'react';
import { Box, Grid, Typography, TextField, IconButton, Paper, Button } from '@mui/material';
import FilterListIcon from '@mui/icons-material/FilterList';
import ProductCard from '../components/ProductCard';
import OrderSummary from '../components/OrderSummary';
import { getProducts } from '../Api/products';

export default function Products() {
    const [products, setProducts] = useState([]);
    const [cart, setCart] = useState([]);

   const addToCart = (product) => {
    setCart([...cart, product]);
   }
    
    useEffect(() => {
        const fetchProducts = async () => {
            try {
                const response = await getProducts();
                const { data, meta } = response;
                setProducts(data);
            } catch (error) {
                alert(error.response.data.message)
            }
        };
        fetchProducts();
    }, []);
  return (
    <Box sx={{ display: 'flex', flexDirection: { xs: 'column', md: 'row' }, gap: 4, mt: 4 }}>
      <Box sx={{ flex: 3 }}>
        <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 2 }}>
          <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
            <IconButton><FilterListIcon /></IconButton>
            <TextField size="small" placeholder="Search by product name" fullWidth sx={{ maxWidth: 300 }} />
          </Box>
        </Box>

       
        <Typography variant="body2" color="textSecondary" gutterBottom>Showing 1-6 of 6 Products</Typography>

        <Grid container spacing={2}>
          {products.map((product, i) => (
            <Grid item xs={12} sm={6} md={4} key={product.id}>
              <ProductCard product={product} addToCart={addToCart} cart={cart}/>
            </Grid>
          ))}
        </Grid>

        {/* Pagination Placeholder */}
        <Box sx={{ display: 'flex', justifyContent: 'center', mt: 4 }}>
          <Button disabled>{'< Previous'}</Button>
          <Button variant="contained">1</Button>
          <Button disabled>{'Next >'}</Button>
        </Box>
      </Box>

      <Box sx={{ flex: 1 }}>
        <OrderSummary />
      </Box>
    </Box>
  );
};
