import java.util.Random;
/** This class serevs as a study of the datastructure formally known as a "Graph" 
 * 
 * Functional specification:
 * This class should be able to tell me:
 * 1) how many vertices are in a graph      : solution: +getNumberOfVertices():int
 * 2) The current number of edges           : solution: +getNumberOfEdges():int
 * 3) find the first neighbor of a vertex   : solution: +getFirstNeighbor(int vertex):int   will return the  value j(vertex index) from matrix[i][j] on the first non-zero J
 * 4) find the next neigbor of a vertex     : solution: +getNextNeighbor(int vertex, vertex_index_offset):int will start at matrix[vertex] and return  the
 * 5) determine if there an edge between V1 and v2 : solution: +isAdjacent(int v1 , int v2):boolean
 * 6) calculate the density
 * 
 * @author Dominizzle
 * 
 * An instance of this class will generate an adjacency matrix of size n, which will be passed to the constructor 
 * as a parameter. The matrix will then pupulate it's self with random weights between 1 and 10.
*/
public class Graphm 
{
    public int numberOfVertices=0;
    public int numberOfEdges = 0;
    public int[][] matrix;

    
    Random weightGenerator = new Random(); //Random randomNum = new Random();
    /** weight range */
    public int weightMin = 0;
    public int weightMax = 4;
    
   
   //constructor
   public Graphm(){};
   //parameterised constructor
   public Graphm(int n)
   {
       numberOfVertices = n;
       matrix = new int[n][n];

       //** pupulate adjacency matrix with weighted edges. For each edge increase numberOfEdges by 1 */
       for(int i = 0; i < numberOfVertices; i++)
       {
            for (int j = 0; j < numberOfVertices; j++)
            {
                
                matrix[i][j] = weightGenerator.nextInt(weightMax)+ weightMin;
                if (matrix[i][j] > 0)
                {
                    numberOfEdges++;
                }
                System.out.print("|"+matrix[i][j] + "|");
            }
            System.out.println();
       }
    
    };
    public int getNumberOfVertices() {
        return this.numberOfVertices;
    }
    public int getNumberOfEdges(){
        return this.numberOfEdges;
    }
    
    /** @param vertex is selects the vertex in question from teh matrix 
        @return j is the first vertex with an edge(non-zero value)
    */
    public int getFirstNeighbor(int vertex) {
        for (int j = 0; j < matrix[vertex].length ; j++)
        {
          // System.out.print(matrix[vertex][j]+ " ");
          if (isEdge(matrix[vertex][j]))
            return j;
        }
        return vertex;
    }
    public int getNextNeighbor(int vertex_index_i,int vertex_index_j)
    {
        for (int j = vertex_index_j; j < matrix[vertex_index_j].length-vertex_index_j;j++ )
        {
            int potentialEdge = matrix[vertex_index_i][j+1];
            System.out.println("potential Edge ["+j+"] weight:"+potentialEdge);
            if (isEdge(potentialEdge))
            {
                return j+1;
            }
        }
        return 0;
    }

    public boolean isEdge(int value){
        if(value > 0)
        {
            return true;
        }
        return false;
    }
    public boolean isAdjacent(int vertex1, int vertex2)
    {
        if(isEdge( matrix[vertex1][vertex2] ) || isEdge(matrix[vertex2][vertex1]) ){ // undirected graph check
            return true;
        }
        return false;
    }



    
}  